<?php


db.visitors.aggregate([

{ $match : { mobile_carrier : "ATM", created_date : "2015-05-07" } },

{   $group: { _id: { country_code: '$country_code', mobile_carrier: '$mobile_carrier' }, ips: { $addToSet: '$ip'} } }, {     $unwind:"$ips" }, {     $group: { _id: "$_id", total: { $sum:1} } } ]);
