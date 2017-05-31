<h3>Новые результаты тестов ({{count($data)}})</h3>

<table class="table table-bordered" style="border: 1px solid #ddd; width: 100%;
        max-width: 100%;
        margin-bottom: 20px;  border-spacing: 0;
        border-collapse: collapse;">
    <thead>
    <tr>
        <th style="padding: 8px; text-align: left">#</th>
        <th style="padding: 8px; text-align: left">ФИО</th>
        <th style="padding: 8px; text-align: left">Код</th>
        <th style="padding: 8px; text-align: left">Дата</th>
        <!--<th style="padding: 8px; text-align: left">Файл</th>-->
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td style=" padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;" scope="row">№ {{$item->client_id}}</td>
            <td style=" padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;">{{$item->name}} {{$item->secondname}}</td>
            <td style=" padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;">{{$item->unique_code}}</td>
            <td style=" padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;">{{$item->created_At->format("d/m/Y H:i")}}</td>
            <!--<td style=" padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;"><a target="_blank" href="{{url("results/")}}">Скачать файл с результатами</a></td>-->
        </tr>
    @endforeach
    </tbody>
</table>