<?php

namespace App\Http\Controllers\Cabinet;

use App\EventsModel;

use App\Http\Controllers\Controller;

use App\Library\Algorithm\Reader;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use App\ClientWork;

use View;

use Auth;

use App\Client;

use App\Work;

use App\ResultTestFiles;

use Carbon\Carbon;

use Illuminate\Support\Facades\Redirect;

use App\Library\UploadFiles;

use App\Library\TransactionsLibrary;

use App\ResultTest;

use Illuminate\Support\Facades\Mail;

use App\Events\HandleTestEvent;

use App\Transaction;

use Illuminate\Support\Facades\Event;


class TestController extends Controller
{
    private $user;
    private $transaction_id;
    private $transactionsLib;

    public function __construct(){
		    $this->user = Auth::user();
        $this->transactionsLib = new TransactionsLibrary();
	}

    private $outExcelData = [];

    public function index(Request $request)
    {

        return View::make('test.typeform');
    }

    public function form()
    {

        $typeWork = Work::orderBy('id', 'desc')->get()->pluck('name', 'id');

        $typeWorkEdited = $typeWork->map(function ($item, $key) {
            return $key . " - " . $item;
        });

        return View::make('test.create', ["work_types" => $typeWorkEdited]);
    }

    public function file()
    {
        return View::make('test.create_file');
    }

    public function fileUpload()
    {


        if (UploadFiles::initUpload("file", "excel")) {

            $file = current(UploadFiles::$files)["file"];

            \Excel::selectSheetsByIndex(0)->load($file, function ($reader) {

                $results = $reader->get()->toArray();

                foreach ($results as $item) {

                    if ($this->correctCountFields($item)) {

                        $inserted = Client::insert([
                            "name" => $item["imya"],
                            "secondname" => $item["otchestvo"],
                            "code" => $item["identifikatsionnyy_kod"],
                            "patronymic" => $item["otchestvo"],
                            "datebirth" => $item["data_rozhdeniya"]->toDateTimeString(),
                            "sex" => $this->convertSex($item["pol"]),
                            "profession" => $item["dolzhnost"],
                            "address_office" => "",
                            "factory_name" => "",
                            "factory_edrpou" => "",
                            "factory_departament" => "",
                            "status_pass" => 1,
                            "payment_type" => 1,
                            "unique_code" => $this->generateUniqueCode()
                        ]);

                        $work_type = array(
                            "id_user" => $inserted->id,
                            "type" => $item["vid_rabot"]
                        );

                        ClientWork::save($work_type);
                    }
                }
            });

            // DATA
            $inserted = Client::insert($this->outExcelData);

            // INSERT TYPE WORK
            // ClientWork::insert($work_type);

            return redirect('cabinet/statistic');
        }
    }

    private function convertDate($dateString)
    {

        return Carbon::createFromFormat('d.m.Y', $dateString)->format('Y-m-d');
    }

    private static function generateUniqueCode($start = 100000, $end = 999999)
    {
        return mt_rand($start, $end);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "code" => "required|string|size:10",
            "secondname" => 'required|string|max:50',
            "name" => 'required|string|min:3|max:50',
            "patronymic" => 'required|string|max:50',
            "day" => "required",
            "month" => "required",
            "year" => "required",
            "sex" => "required|integer",
            "profession" => "required|string|max:100",
            "type_work.*" => "required|integer",
            "address_office" => "string|max:80",
            "factory_name" => "string|max:80",
            "factory_edrpou" => "string|max:50",
            "factory_departament" => "string|max:50",
            "status_pass" => "required|integer",
            "payment_type" => "required|integer"
        ]);



        if ($validator->fails()) {
            return redirect('cabinet/test/form')
                ->withErrors($validator)
                ->withInput();
        }

        $client = new Client();
        $client->name = $request->name;
        $client->secondname = $request->secondname;
        $client->patronymic = $request->patronymic;
        $client->datebirth = $request->year.'-'.$request->month.'-'.$request->day; // 2017-03-17
        $client->sex = $request->sex;
        $client->code = $request->code;
        $client->address_office = $request->address_office;
        $client->factory_name = $request->factory_name;
        $client->factory_edrpou = $request->factory_edrpou;
        $client->factory_departament = $request->factory_departament;
        $client->status_pass = $request->status_pass;
        $client->payment_type = $request->payment_type;
        $client->profession = $request->profession;
        $client->group_r = 0;
        $client->enterprise_id = Auth::user()->id;
        $client->unique_code = $this->generateUniqueCode();

        $client->save();

        // Insert type works

        foreach($request->type_work as $v){
            $data[] = array(
                "id_user" => $client->id,
                "type"    =>  $v
            );
        }

        if(!empty($data)) {
            ClientWork::insert($data);
        }
        //

        return redirect('cabinet/registered?status=0')->with('user', $client->unique_code)->with('fio', $client->name . ' ' . $client->secondname . ' ' . $client->patronymic);
    }

    public function resultTicketView()
    {
        return View::make('test.registration_complete');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $client = Client::find($id)->with("types")->first();
        $typeWorks = Work::orderBy('id')->get()->pluck('name', 'id');

        return View::make('test.edit', ['client' => $client, "typeWorks" => $typeWorks]);
    }

    private function convertSex($value)
    {

        if ($value == "муж") {
            return "1";
        }

        return "0";
    }

    private function correctCountFields($data)
    {
        return (count($data) == 12) ? true : false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|min:3|max:50',
            "secondname" => 'required|string|max:50',
            "patronymic" => 'required|string|max:50',
            "datebirth" => "required|date",
            "sex" => "required|integer",
            "profession" => "required|string|max:100",
            "code" => "required|numeric",
            "address_office" => "required|string|max:80",
            "type_work" => "required|integer",
            "factory_name" => "required|string|max:80",
            "factory_edrpou" => "required|string|max:50",
            "factory_departament" => "required|string|max:50",
            "status_pass" => "required|integer",
            "payment_type" => "required|integer"
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $client = Client::findOrFail($id);

        $input = $request->all();
        $input["enterprise_id"] = Auth::user()->id;
        $client->fill($input)->save();
        $client->save();

        return redirect('cabinet/statistic')->with('flash_message', 'Успешно обновлено!');
    }

   // Works after push button "Send"
    public function sendResults(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "selected.*" => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator, 400);
        }

        $results = ResultTestFiles::whereIn("client_id", $request->selected)->get();

            try{

                $results = $results->map(function ($item) {

                   
                    // Event to handle result of tests - Algorithm PFZ
                    Event::fire(new HandleTestEvent($item->file, $item));
                    Client::where("unique_code", $item->client_id)->update(["status" => 3]);
                    
                     // Save transactions number in Array to take the last transaction ID in Try/Catch
                    $this->transactionsLib->addTransaction($item);

                    // Check if transaction was sent repetly
                    $this->transactionsLib->repeatTransaction($item->client_id);

                    return $item;
                });

          } catch(\Exception $e){
          	
          
    
            $this->transactionsLib->changeTransactionStatus($this->transactionsLib->_returnTransactionId(), 0);
            dd($e);

          }


        /*Mail::send('emails.results', ["data" => $results], function ($message) {
            $message->from('pfzexpmailer@gmail.com', 'Ukraine Test');
            $message->to(config('app.email_admin'));
            $message->subject('Новые результаты тестов');
        });*/

        return response()->json(["results" => $results, "total" => $results->count()]);
    }

    private function load($file)
    {

        $read = new Reader($file);
        $codes = $read->uniqueCodes();
        $data = [];

        $rows = Client::whereIn("unique_code", $codes)->get();

        foreach ($rows as $key => $item) {

            if (!$this->isLoaded($item->id)) {
                $data["error"][] = array(
                    "id" => $item->id,
                    "name" => $item->name . " " . $item->secondname
                );
                continue;
            }

            $client = new Client();
            $client = $client->where("unique_code", $item->unique_code);
            $client->update(
                ["status" => 1]
            );

            $codes = ResultTestFiles::where("client_id", $item->unique_code)->get();

            if($codes->count() > 0){
                throw new \Exception('Этот файл тестов был уже ранее загружен!');
            }

            // Save loaded file to DB for transaction
            ResultTestFiles::insert([
                "file" => $file,
                "client_id" => $item->unique_code
            ]);

            $data[] = $item->unique_code;

        }

        return $data;
    }

    public function loadResultTest()
    {

        $data = [];

        try {

            UploadFiles::initUpload("files", "result_test");

            if (!UploadFiles::exist()) {
                throw new \Exception('File not loaded');
            }

            foreach (UploadFiles::$files as $file) {
                $data["codes"] = array_merge($data, $this->load($file["file"]));
            }

            if(is_null($data["codes"])){
                throw new \Exception('В базе данных нет клиентов с идентификаторами из загруженного файла!');
            }

        } catch (\Exception $e) {
            // #". $e->getLine()
            return response()->json(["error" => $e->getMessage()], 400);
        }



        return response()->json($data);

    }

    private function _lastIncrementId()
    {

        $results = ResultTest::all();
        $id = $results->max("id");

        return is_null($id) ? 1 : $id;
    }

    public
    function change(Request $request)
    {

        $data = [];

        foreach ($request->selected as $key => $value) {

            $data[] = Client::where("id", $value)->get()->first();
            Client::where("id", $value)->update(["status" => 1]);
        }

        return response()->json(["results" => $data]);

    }

    private
    function isLoaded($client_id)
    {

        $total = ResultTest::where("client_id", $client_id)->get();
        return ($total->count() > 0) ? false : true;
    }
}
