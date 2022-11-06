<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurlController extends Controller
{
    public static array $Cities = [];
    public static array $pharmacies = [];


    public function __construct()
    {

        self::$Cities = ["adiyaman","afyonkarahisar","agri","aksaray","amasya","ankara","antalya","ardahan","artvin","aydin","balikesir","bartin","batman","bayburt","bilecik","bingol","bitlis","bolu","burdur","bursa","canakkale","cankiri","corum","denizli","diyarbakir","duzce","edirne","elazig","erzincan","erzurum","eskisehir","gaziantep","giresun","gumushane","hakkari","hatay","igdir","isparta","istanbul","izmir","kahramanmaras","karabuk","karaman","kars","kastamonu","kayseri","kirikkale","kirklareli","kirsehir","kilis","kocaeli","konya","kutahya","malatya","manisa","mardin","mersin","mugla","mus","nevsehir","nigde","ordu","osmaniye","rize","sakarya","samsun","siirt","sinop","sivas","sanliurfa","sirnak","tekirdag","tokat","trabzon","tunceli","usak","van","yalova","yozgat","zonguldak"];

    }

   public static function index($city)
   {
        $names = [];
        $telNumbers = [];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://www.trnobetcieczane.com/il/". $city ."-nobetci-eczane/");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curl);

        curl_close($curl);

        
        // <div><b>Liste Güncelleme Tarihi : </b> <span> 6 Kasım 2022 </span></div>

        preg_match_all('@<span> (.*?) </span>@', $data, $rows);

        self::$pharmacies["pharmacies"]["info"]["pharmacyCount"] = $rows[1][0];
        self::$pharmacies["pharmacies"]["info"]["updatedAt"] = $rows[1][2];


        preg_match_all('@<div class="eczanelistcontent">(.*?)</div>@', $data, $rows);


        for ($i=0; $i < count($rows) ; $i++) { 
            for ($a=0; $a < count($rows[$i]) ; $a++) { 
                preg_match('@<a class="ta" href="(.*?)">(.*?)</a>@', $rows[$i][$a], $name);
                self::$pharmacies["pharmacies"][$a]["pharmacyName"] = $name[2];
            }
        }

        

        preg_match_all('@<div class="eczanephone">(.*?)</div>@', $data, $rows);

        for ($i=0; $i < count($rows) ; $i++) { 
            for ($a=0; $a < count($rows[$i]) ; $a++) { 
                preg_match('@<a class="phonelink" href="tel:(.*?)">(.*?)</a>@', $rows[$i][$a], $tel);
                self::$pharmacies["pharmacies"][$a]["tel"] = $tel[1];
            }
        }

        preg_match_all('@<div><b>Adres  </b>(.*?)</div>@', $data, $rows);

        for ($i=0; $i < count($rows[1]) ; $i++) { 
            self::$pharmacies["pharmacies"][$i]["adress"] = $rows[1][$i];
        }



        return self::$pharmacies;

      
   }
}
