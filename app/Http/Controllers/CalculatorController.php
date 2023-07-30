<?php

namespace App\Http\Controllers;


use App\Helpers\OsuHelper;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Symfony\Component\Process\Process;

class CalculatorController extends Controller
{
    private static $options = [
        'accuracy',
        'combo',
        'mod',
        'misses',
        'mehs',
        'goods',
    ];

    public static function performance(Request $request, string $beatmap_id) {
        $options = $request->query();

        foreach (array_keys($options) as $option) {
            if (!in_array($option, self::$options)) {
                unset($options[$option]);
            }
        }

        $optionsString = OsuHelper::getOptionsString($options);

        $process =  Process::fromShellCommandline('PerformanceCalculator.exe simulate osu ' . $beatmap_id . ' ' . $optionsString);
        $process->setWorkingDirectory(base_path() . DIRECTORY_SEPARATOR . 'osu-tools');
        $process->run();
        $rawPerformance = $process->getOutput();
        return OsuHelper::responseToArray($rawPerformance);
    }
}
