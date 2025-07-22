<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $wll = json_decode(urldecode($_COOKIE['well'] ?? ''), true)[0];
        if ($wll == '') {
            return redirect()->route('rtm.select')->with('error', 'no well were selected!');
        }

        $sat = $wll['well_active'];
        $zon = $wll['time_zone'];
        $nme = $wll['well_name'];
        $tkn = $wll['is_api_token'];
        $com = $wll['company_name'];
        $str = $wll['start_date'];
        $end = $wll['end_date'];
        $typ = $this->getWellType((int) $wll['is_api_token']);

        return view('pages.rtm.index', compact('sat', 'zon', 'nme', 'tkn', 'com', 'str', 'end', 'typ'));
    }

    public function test()
    {
        $sat = 'well_active';
        $zon = 'jakarta/indonesia';
        $nme = 'Test Well';
        $tkn = '';
        $com = 'PT. Test Drilling';
        $str = '';
        $end = '';
        $typ = 'Geothermal';

        return view('pages.rtm.test', compact('sat', 'zon', 'nme', 'tkn', 'com', 'str', 'end', 'typ'));
    }

    public function select()
    {
        $url = sprintf('%s/%s/well/active', getenv('VITE_EXSERVER_URL'), getenv('VITE_EXSERVER_PREFIX'));
        $res = Http::get($url);

        $wll = [];
        $com = [];
        $act = [];

        if ($res->ok()) {
            $wll = $res['response'];
        }

        foreach ($wll as $itm) {
            $com[] = ['id' => $itm['company_name'], 'text' => $itm['company_name']];
            $act[] = ['id' => $itm['company_name'], 'text' => $itm['well_name']];
        }

        $comu = array_values(array_unique($com, SORT_REGULAR));
        return view('pages.rtm.select', compact('comu', 'act', 'wll'));
    }

    protected function getWellType(int $num)
    {
        switch ($num) {
            case 1:
                return 'Oil';
            case 2:
                return 'geothermal';

            default:
                return 'geothermal';
        }
    }
}
