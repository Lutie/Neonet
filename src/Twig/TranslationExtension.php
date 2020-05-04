<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TranslationExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('getTranslation', [$this, 'getTranslation']),
            new TwigFilter('getMultipleTranslation', [$this, 'getMultipleTranslation']),
            new TwigFilter('getInfos', [$this, 'getInfos']),
        ];
    }

    private function getLocales(array $keys) {
        $file_content = file_get_contents("./../locales/locales.json");
        $locales = json_decode($file_content, true);
        $locales = $locales['app'];
        foreach ($keys as $key){
            $locales = $locales[$key]; // loop between the locales in order to get the text needed
        }
        $locales = $locales['fr']; // for the moment we only handle fr language
        $locales = explode("\n", $locales); // explode output in order to get an array containing each lines
        return $locales;
    }

    // Returns as string the first line matching the given keys
    public function getTranslation(array $keys){
        $output = $this->getLocales($keys);
        return $output[0];
    }

    // Return as an array all lines matching the given keys
    public function getMultipleTranslation(array $keys){
        $output = $this->getLocales($keys);
        return $output;
    }

    // Return some infos from env config
    public function getInfos(string $key) {
        switch($key) {
            case 'phone':
                return getenv('CONTACT_PHONE');
            break;
            case 'email':
                return getenv('CONTACT_EMAIL');
            break;
            default:
                return '';
            break;
        }
    }
}