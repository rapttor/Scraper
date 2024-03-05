<?php // ﷽‎
namespace RapTToR;

/**
 * @author rapttor
 *
 * require __DIR__ . '/protected/vendor/autoload.php';
 * define class Controller() when not using Yii framework
 * 
 * classes/export: UserAgent, BigFile, Proxy, Scraper
 */


/**
 * based on  https://github.com/phpfail/UserAgentGenerator, added bots
 * $agent = new userAgent();
 * $userAgent = (new userAgent) ->generate();
 * $UAFireFox = $agent->generate('firefox'); // generates a firefox user agent on either windows or mac
 * $UAChrome = $agent->generate('chrome'); // generates a chrome user agent on either windows or mac
 * $UAMobile = $agent->generate('mobile'); // generates a mobile user agent for either iphone or android
 * $UAWindows = $agent->generate('windows'); // generates a windows user agent for either firefox or chrome
 * $UAMac = $agent->generate('mac'); // generates a mac user agent for either firefox or chrome
 * $UAiPhone = $agent->generate('iphone'); // generates an iphone user agent for iOS 7-10
 * $UAAndroid = $agent->generate('android'); // generates an android user agent for android versions 4.3-7.1, and includes randomly generated device and build number string that is correct for the version of android being displayed.
 */
class UserAgent
{
    /**
     * Windows Operating System list with dynamic versioning
     * @var array $windows_os
     */
    public $windows_os = [
        '[Windows; |Windows; U; |]Windows NT 6.:number0-3:;[ Win64; x64| WOW64| x64|]',
        '[Windows; |Windows; U; |]Windows NT 10.:number0-5:;[ Win64; x64| WOW64| x64|]',
    ];
    /**
     * Linux Operating Systems [limited]
     * @var array $linux_os
     */
    public $linux_os = [
        '[Linux; |][U; |]Linux x86_64',
        '[Linux; |][U; |]Linux i:number5-6::number4-8::number0-6: [x86_64|]'
    ];
    /**
     * Mac Operating System (OS X) with dynamic versioning
     * @var array $mac_os
     */
    public $mac_os = [
        'Macintosh; [U; |]Intel Mac OS X :number7-9:_:number0-9:_:number0-9:',
        'Macintosh; [U; |]Intel Mac OS X 10_:number0-12:_:number0-9:'
    ];
    /**
     * Versions of Android to be used
     * @var array $androidVersions
     */
    public $androidVersions = [
        '4.3.1',
        '4.4',
        '4.4.1',
        '4.4.4',
        '5.0',
        '5.0.1',
        '5.0.2',
        '5.1',
        '5.1.1',
        '6.0',
        '6.0.1',
        '7.0',
        '7.1',
        '7.1.1'
    ];
    /**
     * Holds the version of android for the User Agent being generated
     * @property string $androidVersion
     */
    public $androidVersion;
    /**
     * Android devices and for specific android versions
     * @var array $androidDevices
     */
    public $androidDevices = [
        '4.3' => [
            'GT-I9:number2-5:00 Build/JDQ39',
            'Nokia 3:number1-3:[10|15] Build/IMM76D',
            '[SAMSUNG |]SM-G3:number1-5:0[R5|I|V|A|T|S] Build/JLS36C',
            'Ascend G3:number0-3:0 Build/JLS36I',
            '[SAMSUNG |]SM-G3:number3-6::number1-8::number0-9:[V|A|T|S|I|R5] Build/JLS36C',
            'HUAWEI G6-L:number10-11: Build/HuaweiG6-L:number10-11:',
            '[SAMSUNG |]SM-[G|N]:number7-9:1:number0-8:[S|A|V|T] Build/[JLS36C|JSS15J]',
            '[SAMSUNG |]SGH-N0:number6-9:5[T|V|A|S] Build/JSS15J',
            'Samsung Galaxy S[4|IV] Mega GT-I:number89-95:00 Build/JDQ39',
            'SAMSUNG SM-T:number24-28:5[s|a|t|v] Build/[JLS36C|JSS15J]',
            'HP :number63-73:5 Notebook PC Build/[JLS36C|JSS15J]',
            'HP Compaq 2:number1-3:10b Build/[JLS36C|JSS15J]',
            'HTC One 801[s|e] Build/[JLS36C|JSS15J]',
            'HTC One max Build/[JLS36C|JSS15J]',
            'HTC Xplorer A:number28-34:0[e|s] Build/GRJ90',
        ],
        '4.4' => [
            'XT10:number5-8:0 Build/SU6-7.3',
            'XT10:number12-52: Build/[KXB20.9|KXC21.5]',
            'Nokia :number30-34:10 Build/IMM76D',
            'E:number:20-23::number0-3::number0-4: Build/24.0.[A|B].1.34',
            '[SAMSUNG |]SM-E500[F|L] Build/KTU84P',
            'LG Optimus G Build/KRT16M',
            'LG-E98:number7-9: Build/KOT49I',
            'Elephone P:number2-6:000 Build/KTU84P',
            'IQ450:number0-4: Quad Build/KOT49H',
            'LG-F:number2-5:00[K|S|L] Build/KOT49[I|H]',
            'LG-V:number3-7::number0-1:0 Build/KOT49I',
            '[SAMSUNG |]SM-J:number1-2::number0-1:0[G|F] Build/KTU84P',
            '[SAMSUNG |]SM-N80:number0-1:0 Build/[KVT49L|JZO54K]',
            '[SAMSUNG |]SM-N900:number5-8: Build/KOT49H',
            '[SAMSUNG-|]SGH-I337[|M] Build/[JSS15J|KOT49H]',
            '[SAMSUNG |]SM-G900[W8|9D|FD|H|V|FG|A|T] Build/KOT49H',
            '[SAMSUNG |]SM-T5:number30-35: Build/[KOT49H|KTU84P]',
            '[Google |]Nexus :number5-7: Build/KOT49H',
            'LG-H2:number0-2:0 Build/KOT49[I|H]',
            'HTC One[_M8|_M9|0P6B|801e|809d|0P8B2|mini 2|S][ dual sim|] Build/[KOT49H|KTU84L]',
            '[SAMSUNG |]GT-I9:number3-5:0:number0-6:[V|I|T|N] Build/KOT49H',
            'Lenovo P7:number7-8::number1-6: Build/[Lenovo|JRO03C]',
            'LG-D95:number1-8: Build/KOT49[I|H]',
            'LG-D:number1-8::number0-8:0 Build/KOT49[I|H]',
            'Nexus5 V:number6-7:.1 Build/KOT49H',
            'Nexus[_|] :number4-10: Build/[KOT49H|KTU84P]',
            'Nexus[_S_| S ][4G |]Build/GRJ22',
            '[HM NOTE|NOTE-III|NOTE2 1LTE[TD|W|T]',
            'ALCATEL ONE[| ]TOUCH 70:number2-4::number0-9:[X|D|E|A] Build/KOT49H',
            'MOTOROLA [MOTOG|MSM8960|RAZR] Build/KVT49L'
        ],
        '5.0' => [
            'Nokia :number10-11:00 [wifi|4G|LTE] Build/GRK39F',
            'HTC 80:number1-2[s|w|e|t] Build/[LRX22G|JSS15J]',
            'Lenovo A7000-a Build/LRX21M;',
            'HTC Butterfly S [901|919][s|d|] Build/LRX22G',
            'HTC [M8|M9|M8 Pro Build/LRX22G',
            'LG-D3:number25-37: Build/LRX22G',
            'LG-D72:number0-9: Build/LRX22G',
            '[SAMSUNG |]SM-G4:number0-9:0 Build/LRX22[G|C]',
            '[|SAMSUNG ]SM-G9[00|25|20][FD|8|F|F-ORANGE|FG|FQ|H|I|L|M|S|T] Build/[LRX21T|KTU84F|KOT49H]',
            '[SAMSUNG |]SM-A:number7-8:00[F|I|T|H|] Build/[LRX22G|LMY47X]',
            '[SAMSUNG-|]SM-N91[0|5][A|V|F|G|FY] Build/LRX22C',
            '[SAMSUNG |]SM-[T|P][350|550|555|355|805|800|710|810|815] Build/LRX22G',
            'LG-D7:number0-2::number0-9: Build/LRX22G',
            '[LG|SM]-[D|G]:number8-9::number0-5::number0-9:[|P|K|T|I|F|T1] Build/[LRX22G|KOT49I|KVT49L|LMY47X]'
        ],
        '5.1' => [
            'Nexus :number5-9: Build/[LMY48B|LRX22C]',
            '[|SAMSUNG ]SM-G9[28|25|20][X|FD|8|F|F-ORANGE|FG|FQ|H|I|L|M|S|T] Build/[LRX22G|LMY47X]',
            '[|SAMSUNG ]SM-G9[35|350][X|FD|8|F|F-ORANGE|FG|FQ|H|I|L|M|S|T] Build/[MMB29M|LMY47X]',
            '[MOTOROLA |][MOTO G|MOTO G XT1068|XT1021|MOTO E XT1021|MOTO XT1580|MOTO X FORCE XT1580|MOTO X PLAY XT1562|MOTO XT1562|MOTO XT1575|MOTO X PURE XT1575|MOTO XT1570 MOTO X STYLE] Build/[LXB22|LMY47Z|LPC23|LPK23|LPD23|LPH223]'
        ],
        '6.0' => [
            '[SAMSUNG |]SM-[G|D][920|925|928|9350][V|F|I|L|M|S|8|I] Build/[MMB29K|MMB29V|MDB08I|MDB08L]',
            'Nexus :number5-7:[P|X|] Build/[MMB29K|MMB29V|MDB08I|MDB08L]',
            'HTC One[_| ][M9|M8|M8 Pro] Build/MRA58K',
            'HTC One[_M8|_M9|0P6B|801e|809d|0P8B2|mini 2|S][ dual sim|] Build/MRA58K'
        ],
        '7.0' => [
            'Pixel [XL|C] Build/[NRD90M|NME91E]',
            'Nexus :number5-9:[X|P|] Build/[NPD90G|NME91E]',
            '[SAMSUNG |]GT-I:number91-98:00 Build/KTU84P',
            'Xperia [V |]Build/NDE63X',
            'LG-H:number90-93:0 Build/NRD90[C|M]'
        ],
        '7.1' => [
            'Pixel [XL|C] Build/[NRD90M|NME91E]',
            'Nexus :number5-9:[X|P|] Build/[NPD90G|NME91E]',
            '[SAMSUNG |]GT-I:number91-98:00 Build/KTU84P',
            'Xperia [V |]Build/NDE63X',
            'LG-H:number90-93:0 Build/NRD90[C|M]'
        ]
    ];
    /**
     * List of "OS" strings used for android
     * @var array $android_os
     */
    public $android_os = [
        'Linux; Android :androidVersion:; :androidDevice:',
        //TODO: Add a $windowsDevices variable that does the same as androidDevice
        //'Windows Phone 10.0; Android :androidVersion:; :windowsDevice:',
        'Linux; U; Android :androidVersion:; :androidDevice:',
        'Android; Android :androidVersion:; :androidDevice:',
    ];
    /**
     * List of "OS" strings used for iOS
     * @var array $mobile_ios
     */
    public $mobile_ios = [
        'iphone' => 'iPhone; CPU iPhone OS :number7-11:_:number0-9:_:number0-9:; like Mac OS X;',
        'ipad' => 'iPad; CPU iPad OS :number7-11:_:number0-9:_:number0-9: like Mac OS X;',
        'ipod' => 'iPod; CPU iPod OS :number7-11:_:number0-9:_:number0-9:; like Mac OS X;',
    ];

    /**
     * Get a random operating system
     * @param null|string $os
     * @return string *
     */
    public function getOS($os = NULL)
    {
        $_os = [];
        if ($os === NULL || in_array($os, ['chrome', 'firefox', 'explorer'])) {
            $_os = $os === 'explorer' ? $this->windows_os : array_merge($this->windows_os, $this->linux_os, $this->mac_os);
        } else {
            $_os += $this->{$os . '_os'};
        }
        // randomly select on operating system
        $selected_os = rtrim($_os[random_int(0, count($_os) - 1)], ';');

        // check for spin syntax
        if (strpos($selected_os, '[') !== FALSE) {
            $selected_os = self::processSpinSyntax($selected_os);
        }

        // check for random number syntax
        if (strpos($selected_os, ':number') !== FALSE) {
            $selected_os = self::processRandomNumbers($selected_os);
        }

        if (random_int(1, 100) > 50) {
            $selected_os .= '; en-US';
        }
        return $selected_os;
    }

    /**
     * Get Mobile OS
     * @param null|string $os Can specifiy android, iphone, ipad, ipod, or null/blank for random
     * @return string *
     */
    public function getMobileOS($os = NULL)
    {
        $os = strtolower($os);
        $_os = [];
        switch ($os) {
            case 'android':
                $_os += $this->android_os;
                break;
            case 'iphone':
            case 'ipad':
            case 'ipod':
                $_os[] = $this->mobile_ios[$os];
                break;
            default:
                $_os = array_merge($this->android_os, array_values($this->mobile_ios));
        }
        // select random mobile os
        $selected_os = rtrim($_os[random_int(0, count($_os) - 1)], ';');
        if (strpos($selected_os, ':androidVersion:') !== FALSE) {
            $selected_os = $this->processAndroidVersion($selected_os);
        }
        if (strpos($selected_os, ':androidDevice:') !== FALSE) {
            $selected_os = $this->addAndroidDevice($selected_os);
        }
        if (strpos($selected_os, ':number') !== FALSE) {
            $selected_os = self::processRandomNumbers($selected_os);
        }
        return $selected_os;
    }

    /**
     *  static::processRandomNumbers
     * @param $selected_os
     * @return null|string|string[] *
     */
    public static function processRandomNumbers($selected_os)
    {
        return preg_replace_callback('/:number(\d+)-(\d+):/i', function ($matches) {
            return random_int($matches[1], $matches[2]);
        }, $selected_os);
    }

    /**
     *  static::processSpinSyntax
     * @param $selected_os
     * @return null|string|string[] *
     */
    public static function processSpinSyntax($selected_os)
    {
        return preg_replace_callback('/\[([\w\-\s|;]*?)\]/i', function ($matches) {
            $shuffle = explode('|', $matches[1]);
            return $shuffle[array_rand($shuffle)];
        }, $selected_os);
    }

    /**
     * processAndroidVersion
     * @param $selected_os
     * @return null|string|string[] *
     */
    public function processAndroidVersion($selected_os)
    {
        $this->androidVersion = $version = $this->androidVersions[array_rand($this->androidVersions)];
        return preg_replace_callback('/:androidVersion:/i', function ($matches) use ($version) {
            return $version;
        }, $selected_os);
    }

    /**
     * addAndroidDevice
     * @param $selected_os
     * @return null|string|string[] *
     */
    public function addAndroidDevice($selected_os)
    {
        $devices = $this->androidDevices[substr($this->androidVersion, 0, 3)];
        $device = $devices[array_rand($devices)];

        $device = self::processSpinSyntax($device);
        return preg_replace_callback('/:androidDevice:/i', function ($matches) use ($device) {
            return $device;
        }, $selected_os);
    }

    /**
     *  static::chromeVersion
     * @param $version
     * @return string *
     */
    public static function chromeVersion($version)
    {
        return random_int($version['min'], $version['max']) . '.0.' . random_int(1000, 4000) . '.' . random_int(100, 400);
    }

    /**
     *  static::firefoxVersion
     * @param $version
     * @return string *
     */
    public static function firefoxVersion($version)
    {
        return random_int($version['min'], $version['max']) . '.' . random_int(0, 9);
    }

    /**
     *  static::windows
     * @param $version
     * @return string *
     */
    public static function windows($version)
    {
        return random_int($version['min'], $version['max']) . '.' . random_int(0, 9);
    }

    /**
     * generate
     * @param null $userAgent
     * @return string *
     */
    public function generate($userAgent = NULL)
    {
        if ($userAgent === NULL) {
            $r = random_int(0, 100);
            if ($r >= 44) {
                $userAgent = array_rand(['firefox' => 1, 'chrome' => 1, 'explorer' => 1]);
            } else {
                $userAgent = array_rand(['iphone' => 1, 'android' => 1, 'mobile' => 1]);
            }
        } elseif ($userAgent == "BOTS") { // all bots
            return array(
                "Google bot" => self::generate("BOTGoogle"),
                "Bing bot" => self::generate("BOTBing"),
                "Yahoo! bot" => self::generate("BOTYahoo"),
            );
        } elseif ($userAgent == "BOT") { // random bot
            $bots = self::generate('BOTS');
            $r = array_rand($bots);
            return $bots[$r];
        } elseif ($userAgent == "BOTGoogle") {
            return "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)";
        } elseif ($userAgent == "BOTBing") {
            return "Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)";
        } elseif ($userAgent == "BOTYahoo") {
            return "Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)";
        } elseif ($userAgent == 'windows' || $userAgent == 'mac' || $userAgent == 'linux') {
            $agents = ['firefox' => 1, 'chrome' => 1];
            if ($userAgent == 'windows') {
                $agents['explorer'] = 1;
            }
            $userAgent = array_rand($agents);
        }
        $_SESSION['agent'] = $userAgent;
        if ($userAgent == 'chrome') {
            return 'Mozilla/5.0 (' . $this->getOS($userAgent) . ') AppleWebKit/' . (random_int(1, 100) > 50 ? random_int(533, 537) : random_int(600, 603)) . '.' . random_int(1, 50) . ' (KHTML, like Gecko) Chrome/' . self::chromeVersion([
                'min' => 47,
                'max' => 55
            ]) . ' Safari/' . (random_int(1, 100) > 50 ? random_int(533, 537) : random_int(600, 603));
        } elseif ($userAgent == 'firefox') {

            return 'Mozilla/5.0 (' . $this->getOS($userAgent) . ') Gecko/' . (random_int(1, 100) > 30 ? '20100101' : '20130401') . ' Firefox/' . self::firefoxVersion([
                'min' => 45,
                'max' => 74
            ]);
        } elseif ($userAgent == 'explorer') {

            return 'Mozilla / 5.0 (compatible; MSIE ' . ($int = random_int(7, 11)) . '.0; ' . $this->getOS('windows') . ' Trident / ' . ($int == 7 || $int == 8 ? '4' : ($int == 9 ? '5' : ($int == 10 ? '6' : '7'))) . '.0)';
        } elseif ($userAgent == 'mobile' || $userAgent == 'android' || $userAgent == 'iphone' || $userAgent == 'ipad' || $userAgent == 'ipod') {

            return 'Mozilla/5.0 (' . $this->getMobileOS($userAgent) . ') AppleWebKit/' . (random_int(1, 100) > 50 ? random_int(533, 537) : random_int(600, 603)) . '.' . random_int(1, 50) . ' (KHTML, like Gecko)  Chrome/' . self::chromeVersion([
                'min' => 47,
                'max' => 55
            ]) . ' Mobile Safari/' . (random_int(1, 100) > 50 ? random_int(533, 537) : random_int(600, 603)) . '.' . random_int(0, 9);
        } else {
            new Exception('Unable to determine user agent to generate');
        }
    }
}

class Bigfile
{
    protected $file;

    /**
     * @param mixed $filename
     * @param string $mode
     */
    public function __construct($filename, $mode = "r")
    {
        /* if (!file_exists($filename)) {

            throw new Exception("File not found");

        }*/

        $this->file = new \SplFileObject($filename, $mode);
    }

    /**
     * @return [type]
     */
    protected function iterateText()
    {
        $count = 0;

        while (!$this->file->eof()) {

            yield $this->file->fgets();

            $count++;
        }
        return $count;
    }

    /**
     * @param mixed $bytes
     * 
     * @return [type]
     */
    /**
     * @param mixed $bytes
     * 
     * @return [type]
     */
    protected function iterateBinary($bytes)
    {
        $count = 0;

        while (!$this->file->eof()) {

            yield $this->file->fread($bytes);

            $count++;
        }
    }

    /**
     * @param string $type
     * @param null $bytes
     * 
     * @return [type]
     */
    public function iterate($type = "Text", $bytes = NULL)
    {
        if ($type == "Text") {

            return new \NoRewindIterator($this->iterateText());
        } else {

            return new \NoRewindIterator($this->iterateBinary($bytes));
        }
    }
}


class Proxy
{

    /**
     * @param mixed $ip
     * @param bool $allow_private
     * @param array $proxy_ip
     * 
     * @return [type]
     */
    public static function serverIP($ip, $allow_private = false, $proxy_ip = [])
    {
        if (!is_string($ip) || is_array($proxy_ip) && in_array($ip, $proxy_ip))
            return false;
        $filter_flag = FILTER_FLAG_NO_RES_RANGE;

        if (!$allow_private) {
            //Disallow loopback IP range which doesn't get filtered via 'FILTER_FLAG_NO_PRIV_RANGE' [1]
            //[1] https://www.php.net/manual/en/filter.filters.validate.php
            if (preg_match('/^127\.$/', $ip))
                return false;
            $filter_flag |= FILTER_FLAG_NO_PRIV_RANGE;
        }

        return filter_var($ip, FILTER_VALIDATE_IP, $filter_flag) !== false;
    }
    /**
     * @param bool $allow_private
     * 
     * @return [type]
     */
    public static function clientIP($allow_private = false)
    {
        //Place your trusted proxy server IPs here.
        $proxy_ip = array('127.0.0.1');

        //The header to look for (Make sure to pick the one that your trusted reverse proxy is sending or else you can get spoofed)
        $header = 'HTTP_X_FORWARDED_FOR'; //HTTP_CLIENT_IP, HTTP_X_FORWARDED, HTTP_FORWARDED_FOR, HTTP_FORWARDED

        //If 'REMOTE_ADDR' seems to be a valid client IP, use it.
        if (self::serverIP($_SERVER['REMOTE_ADDR'], $allow_private, $proxy_ip))
            return $_SERVER['REMOTE_ADDR'];

        if (isset($_SERVER[$header])) {
            //Split comma separated values [1] in the header and traverse the proxy chain backwards.
            //[1] https://en.wikipedia.org/wiki/X-Forwarded-For#Format
            $chain = array_reverse(preg_split('/\s*,\s*/', $_SERVER[$header]));
            foreach ($chain as $ip)
                if (self::serverIP($ip, $allow_private, $proxy_ip))
                    return $ip;
        }

        return null;
    }

    //https://deviceatlas.com/blog/list-of-user-agent-strings
    /**
     * @return [type]
     */
    public static function agentsBot()
    {
        return array(
            "Google bot" =>
                "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)",
            "Bing bot" =>
                "Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)",
            "Yahoo! bot" =>
                "Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)",
        );
    }

    /**
     * @return [type]
     */
    public static function agentsDesktop()
    {
        return array(
            "Windows 10-based PC using Edge browser" =>
                "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246",
            "Chrome OS-based laptop using Chrome browser (Chromebook)" =>
                "Mozilla/5.0 (X11; CrOS x86_64 8172.45.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.64 Safari/537.36",
            "Mac OS X-based computer using a Safari browser" =>
                "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/601.3.9 (KHTML, like Gecko) Version/9.0.2 Safari/601.3.9",
            "Windows 7-based PC using a Chrome browser" =>
                "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36",
            "Linux-based PC using a Firefox browser" =>
                "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:15.0) Gecko/20100101 Firefox/15.0.1",
        );
    }

    /**
     * @return [type]
     */
    public static function agentsTablet()
    {
        return array(
            "Google Pixel C" =>
                "Mozilla/5.0 (Linux; Android 7.0; Pixel C Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/52.0.2743.98 Safari/537.36",
            "Sony Xperia Z4 Tablet" =>
                "Mozilla/5.0 (Linux; Android 6.0.1; SGP771 Build/32.2.A.0.253; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/52.0.2743.98 Safari/537.36",
            "Nvidia Shield Tablet K1" =>
                "Mozilla/5.0 (Linux; Android 6.0.1; SHIELD Tablet K1 Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/55.0.2883.91 Safari/537.36",
            "Samsung Galaxy Tab S3" =>
                "Mozilla/5.0 (Linux; Android 7.0; SM-T827R4 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.116 Safari/537.36",
            "Samsung Galaxy Tab A" =>
                "Mozilla/5.0 (Linux; Android 5.0.2; SAMSUNG SM-T550 Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/3.3 Chrome/38.0.2125.102 Safari/537.36",
            "Amazon Kindle Fire HDX 7" =>
                "Mozilla/5.0 (Linux; Android 4.4.3; KFTHWI Build/KTU84M) AppleWebKit/537.36 (KHTML, like Gecko) Silk/47.1.79 like Chrome/47.0.2526.80 Safari/537.36",
            "LG G Pad 7.0" =>
                "Mozilla/5.0 (Linux; Android 5.0.2; LG-V410/V41020c Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/34.0.1847.118 Safari/537.36",
        );
    }

    /**
     * @return [type]
     */
    public static function agentsWindowsMobile()
    {
        return array(
            "Microsoft Lumia 650" =>
                "Mozilla/5.0 (Windows Phone 10.0; Android 6.0.1; Microsoft; RM-1152) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Mobile Safari/537.36 Edge/15.15254",
            "Microsoft Lumia 550" =>
                "Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; RM-1127_16056) AppleWebKit/537.36(KHTML, like Gecko) Chrome/42.0.2311.135 Mobile Safari/537.36 Edge/12.10536",
            "Microsoft Lumia 950" =>
                "Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.1058",
        );
    }

    /**
     * @return [type]
     */
    public static function agentsIOS()
    {
        return array(
            "Apple iPhone XR (Safari)" =>
                "Mozilla/5.0 (iPhone; CPU iPhone OS 12_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 Mobile/15E148 Safari/604.1",
            "Apple iPhone XS (Chrome)" =>
                "Mozilla/5.0 (iPhone; CPU iPhone OS 12_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/69.0.3497.105 Mobile/15E148 Safari/605.1",
            "Apple iPhone XS Max (Firefox)" =>
                "Mozilla/5.0 (iPhone; CPU iPhone OS 12_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/13.2b11866 Mobile/16A366 Safari/605.1.15",
            "Apple iPhone X" =>
                "Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1",
            "Apple iPhone 8" =>
                "Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.34 (KHTML, like Gecko) Version/11.0 Mobile/15A5341f Safari/604.1",
            "Apple iPhone 8 Plus" =>
                "Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A5370a Safari/604.1",
            "Apple iPhone 7" =>
                "Mozilla/5.0 (iPhone9,3; U; CPU iPhone OS 10_0_1 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/14A403 Safari/602.1",
            "Apple iPhone 7 Plus" =>
                "Mozilla/5.0 (iPhone9,4; U; CPU iPhone OS 10_0_1 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/14A403 Safari/602.1",
            "Apple iPhone 6" =>
                "Mozilla/5.0 (Apple-iPhone7C2/1202.466; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A543 Safari/419.3",
        );
    }

    /**
     * @return [type]
     */
    public static function agentsAndroid()
    {
        return array(
            "Samsung Galaxy S9" =>
                "Mozilla/5.0 (Linux; Android 8.0.0; SM-G960F Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.84 Mobile Safari/537.36",
            "Samsung Galaxy S8" =>
                "Mozilla/5.0 (Linux; Android 7.0; SM-G892A Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/60.0.3112.107 Mobile Safari/537.36",
            "Samsung Galaxy S7" =>
                "Mozilla/5.0 (Linux; Android 7.0; SM-G930VC Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/58.0.3029.83 Mobile Safari/537.36",
            "Samsung Galaxy S7 Edge" =>
                "Mozilla/5.0 (Linux; Android 6.0.1; SM-G935S Build/MMB29K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/55.0.2883.91 Mobile Safari/537.36",
            "Samsung Galaxy S6" =>
                "Mozilla/5.0 (Linux; Android 6.0.1; SM-G920V Build/MMB29K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36",
            "Samsung Galaxy S6 Edge Plus" =>
                "Mozilla/5.0 (Linux; Android 5.1.1; SM-G928X Build/LMY47X) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.83 Mobile Safari/537.36",
            "Nexus 6P" =>
                "Mozilla/5.0 (Linux; Android 6.0.1; Nexus 6P Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.83 Mobile Safari/537.36",
            "Sony Xperia XZ" =>
                "Mozilla/5.0 (Linux; Android 7.1.1; G8231 Build/41.2.A.0.219; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/59.0.3071.125 Mobile Safari/537.36",
            "Sony Xperia Z5" =>
                "Mozilla/5.0 (Linux; Android 6.0.1; E6653 Build/32.2.A.0.253) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36",
            "HTC One X10" =>
                "Mozilla/5.0 (Linux; Android 6.0; HTC One X10 Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/61.0.3163.98 Mobile Safari/537.36",
            "HTC One M9" =>
                "Mozilla/5.0 (Linux; Android 6.0; HTC One M9 Build/MRA58K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.3",
        );
    }

    /**
     * @return [type]
     */
    public static function agents()
    {
        return
            self::agentsAndroid() +
            self::agentsDesktop() +
            self::agentsIOS() +
            self::agentsTablet() +
            self::agentsWindowsMobile();
    }

    /**
     * @param null $id (<1 for random)
     * @param null $agents
     * @return mixed
     */
    public static function agent($id = null, $agents = null)
    {
        if (is_null($agents))
            $agents = self::agents();
        $agents = array_values($agents);
        if (is_null($id) || $id < 1)
            $id = rand(0, count($agents) - 1);
        return $agents[$id];
    }

    /**
     * @return [type]
     */
    public static function file()
    {
        return __DIR__ . "/../data/proxylist.txt";
    }

    /**
     * @return [type]
     */
    public static function load()
    {
        $url = 'https://api.proxyscrape.com?request=getproxies&proxytype=https&timeout=10000&country=all&ssl=all&anonymity=all';
        $data = Scraper::get($url);
        file_put_contents(self::file(), $data);
        return $data;
    }

    /**
     * @param bool $force
     * 
     * @return [type]
     */
    public static function all($force = false)
    {
        if (file_exists(self::file()) && !$force) {
            $data = file_get_contents(self::file());
        } else {
            $data = self::load();
        }
        return $data;
    }

    /**
     * @param null $id (<1 for random)
     * @return array|null
     */
    public static function one($id = null)
    {
        $data = self::all();
        $proxies = explode("\r\n", $data);
        if (strlen($data) > 0 && count($proxies) > 2) {
            if (is_null($id) || $id < 1)
                $id = rand(0, count($proxies) - 2);
            $proxyUrl = $proxies[$id];
            $p = explode(":", $proxyUrl);
            if (count($p) == 1 || strlen($p[1]) == 0)
                $p[1] = "80";
            $p[2] = $id;
            return $p;
        }
        return null;
    }
}



class Scraper extends \RapTToR\Helper
{

    public static $cachedir = "./cache/";



    public static $accountTypeLimits = array(
        0 => 200,
        // instagram
    );


    /**
     * @param mixed $string
     * 
     * @return [type]
     */
    public static function hyphenize($string)
    {
        $dict = array(
            "I'm" => "I am",
            //"thier"    => "their",
        );
        return strtolower(
            preg_replace(
                array('#[\\s-]+#', '#[^A-Za-z0-9\. -]+#'),
                array('-', ''),
                // the full cleanString() can be downloaded from http://www.unexpectedit.com/php/php-clean-string-of-utf8-chars-convert-to-similar-ascii-char
                self::cleanString(
                    str_replace(
                        array_keys($dict),
                        array_values($dict),
                        urldecode($string)
                    )
                )
            )
        );
    }

    /**
     * @param mixed $s
     * 
     * @return [type]
     */
    public static function slug($s)
    {
        $o = $s;
        if (is_array($s))
            $s = serialize($s);
        if (is_object($s))
            $s = json_encode($s);
        $s = self::cleanString($s);
        $s = str_replace(' ', '-', $s); // Replaces all spaces with hyphens.
        $s = preg_replace('/[^A-Za-z0-9\-]/', '', $s); // Removes special chars.
        return $s;
    }

    /**
     * @param null $id
     * 
     * @return [type]
     */
    public static function browser($id = null)
    {
        $browsers = array();
        if (is_null($id) || !isset($browsers[$id]))
            $id = rand(0, count($browsers) - 1);
        return $browsers[$id];
    }


    /**
     * @param mixed $URL
     * 
     * @return [type]
     */
    public static function curl_get_yql($URL)
    {
        $yql_base_url = "http://query.yahooapis.com/v1/public/yql";
        $yql_query = "select * from html where url='$URL'";
        $yql_query_url = $yql_base_url . "?q=" . urlencode($yql_query);
        $yql_query_url .= "&format=json";
        return self::get($yql_query_url);
    }

    /**
     * @param mixed $URL
     * @param mixed $data
     * @param null $proxy
     * @param null $agent
     * @param bool $debug
     * 
     * @return [type]
     */
    public static function post($URL, $data, $proxy = null, $agent = null, $debug = false)
    {
        return self::get($URL, $proxy = null, $agent = null, $debug = false, $data);
    }


    /**
     * @param mixed $URL
     * @param null $proxy
     * @param null $agent
     * @param bool $debug
     * @param null $data
     * 
     * @return [type]
     */
    public static function get($URL, $proxy = null, $agent = null, $debug = false, $data = null)
    {
        $c = curl_init();
        $p = "";

        $path_cookie = 'cookie.txt';
        if (!file_exists(realpath($path_cookie)))
            touch($path_cookie);

        /* if (!is_null($proxy)) {
                $p = Proxy::one($proxy);
                curl_setopt($c, CURLOPT_HTTPPROXYTUNNEL, 0);
                curl_setopt($c, CURLOPT_PROXY, $p[0]);
                curl_setopt($c, CURLOPT_PROXYPORT, $p[1]);
            } */
        $a = "";

        if (!is_null($agent)) {
            $a = Proxy::agent($agent, Proxy::agentsBot());
            curl_setopt($c, CURLOPT_USERAGENT, $a);
        }

        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($c, CURLOPT_VERBOSE, true);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($c, CURLOPT_TIMEOUT, 40);
        curl_setopt($c, CURLOPT_COOKIESESSION, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        if (is_file($path_cookie))
            curl_setopt($c, CURLOPT_COOKIEJAR, realpath($path_cookie));

        // curl_setopt($c, CURLOPT_USERAGENT, $agent);
        curl_setopt($c, CURLOPT_URL, $URL);
        if (!is_null($data)) {
            if (is_array($data)) {
                $postvars = '';
                foreach ($data as $key => $value) {
                    $postvars .= $key . "=" . $value . "&";
                }
            } else
                $postvars = $data;
            curl_setopt($c, CURLOPT_POSTFIELDS, $postvars);
        }
        $contents = curl_exec($c);
        if ($debug) {
            $info = "";
            if ($c)
                $info = curl_getinfo($c);
            if (!$contents)
                $contents = null;
            return array(
                "url" => $URL,
                "agent" => $a,
                "proxy" => $p,
                "info" => $info,
                "size" => strlen($contents),
                "data" => $contents,
            );
        }
        curl_close($c);
        if ($contents) {
            return $contents;
        } else
            return FALSE;
    }

    /**
     * @param mixed $url
     * @param bool $debug
     * 
     * @return [type]
     */
    public static function scrape($url, $debug = false)
    {
        error_log("scraping $url");
        return self::get($url, -1, -1, $debug);
    }


    /**
     * @param mixed $string
     * 
     * @return [type]
     */
    public static function parseEmails($string)
    {
        $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
        preg_match_all($pattern, $string, $matches);
        return $matches[0];
    }

    /**
     * @param mixed $string
     * 
     * @return [type]
     */
    public static function parseUrls($string)
    {
        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $string, $match);
        return(is_array($match[0])) ? $match[0] : null;
    }





    /**
     * @param mixed $url
     * @param mixed $type
     * @param mixed $callback
     * @param null $allow
     * @param null $disallow
     * @param null $remove
     * 
     * @return [type]
     */
    public static function ImportLargeUrl($url, $type, $callback, $allow = null, $disallow = null, $remove = null)
    {
        /* while (!feof($handle)) {
                $line = stream_get_line($handle, 1000000, "\n");
            }*/
        $allows = (is_string($allow) && strlen($allow) > 0) ? explode("\r\n", $allow) : null;
        $disallows = (is_string($disallow) && strlen($disallow) > 0) ? explode("\r\n", $disallow) : null;
        $removes = (is_string($remove) && strlen($remove) > 0) ? explode("\r\n", $remove) : null;
        $count = array("import" => 0, "discard" => 0, "allows" => $allows, "disallows" => $disallows);
        $largefile = new Bigfile($url);
        $iterator = $largefile->iterate("Text"); // Text or Binary based on your file type
        foreach ($iterator as $line) {
            $urls = Scraper::parseUrls($line);
            foreach ($urls as $url) {
                $ok = true;
                if (is_array($allows) && count($allows) > 0) {
                    $ok = false;
                    foreach ($allows as $a)
                        if (stripos($url, $a) > -1)
                            $ok = true;
                }
                if (is_array($disallows) && count($disallows) > 0)
                    foreach ($disallows as $a)
                        if (stripos($url, $a) > -1)
                            $ok = false;

                if (is_array($removes) && count($removes) > 0)
                    foreach ($removes as $a)
                        $url = str_ireplace($a, "", $url);

                if ($ok && Scraper::validUrl($url)) {
                    $count["import"]++;
                    $callback($url, $type);
                } else {
                    $count["discard"]++;
                }
            }
        }
        return $count;
    }

    /**
     * @param mixed $url
     * 
     * @return [type]
     */
    public static function validUrl($url)
    {
        $url = filter_var($url, FILTER_SANITIZE_URL);
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    /**
     * @param mixed $email
     * 
     * @return [type]
     */
    public static function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param mixed $strOrgNumber
     * 
     * @return [type]
     */
    public static function onlyNumbers($strOrgNumber)
    {
        return preg_replace('/[^0-9.]+/', '', $strOrgNumber);
    }

    /**
     * @param mixed $url
     * 
     * @return [type]
     */
    public static function fixUrl($url)
    {
        $url = str_ireplace("//", "/", $url);
        $url = str_ireplace("//", "/", $url);
        $url = str_ireplace("//", "/", $url);
        $url = str_ireplace(":/", "://", $url);
        return $url;
    }



    /**
     * @return [type]
     */
    public static function getCacheDir()
    {
        $cache = self::$cachedir;
        @mkdir($cache, 0777, true);
        return $cache;
    }

    /**
     * @param mixed $obj
     * @param bool $deep
     * 
     * @return [type]
     */
    public static function objectToArray($obj, $deep = true)
    {
        $reflectionClass = new \ReflectionClass(get_class($obj));
        $array = array();
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $val = $property->getValue($obj);
            if (true === $deep && is_object($val)) {
                $val = self::objectToArray($val);
            }
            $array[$property->getName()] = $val;
            $property->setAccessible(false);
        }
        return $array;
    }



    /**
     * @param null $url
     * @param int $timeout
     * 
     * @return [type]
     */
    public static function again($url = null, $timeout = 2000)
    {
        if ($timeout < 100)
            $timeout *= 1000;
        ?>
        <script>
            setTimeout(function () {
                <?php if (is_null($url)) { ?>
                    document.location.reload();
                <?php } else { ?>
                    document.location.href = "<?= $url ?>";
                <?php } ?>
            }, <?= $timeout ?>);
        </script>
        <?php
    }

    /**
     * Retrieves the content from the given URL using file_get_contents and stream_context_create.
     *
     * @param string $url The URL of the content to retrieve
     * @return string The content retrieved from the URL
     */
    public static function get_content($url)
    {
        //$agent = (new userAgent)->generate();
        $agent = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3\r\n";
        //$cookie = "Cookie: parser=scraper;\r\n";
        $options = [
            "http" => [
                "header" => $agent,
                //"proxy" => "tcp://$proxy",
                //"request_fulluri" => true, // Required for some proxy configurations
                "follow_location" => 1, // Enable follow redirects
                // "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3\r\n"
            ]
        ];

        /* $proxy = 'proxy_ip:proxy_port'; // Replace 'proxy_ip:proxy_port' with your proxy details
         $proxyAuth = 'username:password'; // Replace 'username:password' with your proxy credentials if required
        
        if (!empty($proxyAuth)) {
            $options["http"]["header"] .= "Proxy-Authorization: Basic " . base64_encode($proxyAuth) . "\r\n";
        }
        */
        $context = stream_context_create($options);
        $html = @file_get_contents($url, false, $context);
        return $html;

    }
    /**
     * @param $url
     * @param bool $forced
     * @param int $timeout // hours
     */
    public static function getCached($url, $forced = false, $timeout = 1)
    {
        $cache = self::getCacheDir();
        if (isset($_REQUEST["force"]))
            $forced = true;
        $filename = $cache . sha1($url) . '.cmp';
        if (is_file($filename)) {
            $content = file_get_contents($filename);
            $content = self::uncmp($content);
            if (self::debug()) {
                error_log($msg = "scraper:: get $url from  $filename");
                echo $msg . '<br/>';
            }
        }
        if (!is_file($filename) || $forced) {
            if (self::debug()) {
                error_log($msg = "scraper:: get $url from web");
                echo $msg . '<br/>';
            }
            $content = self::get($url, null, -1);
            if (strlen($content) > 0) {
                $cmp = self::cmp($content);
                file_put_contents($filename, $cmp);
            }
        }
        return $content;
    }

    /**
     * @param mixed $pages
     * @param null $base
     * 
     * @return [type]
     */
    public static function lastLinks($pages, $base = null)
    {
        if (!is_null($base))
            foreach ($pages as $k => $page)
                if (stripos($page, "http") === false)
                    $pages[$k] = $base . $page;

        $new = [];
        foreach ($pages as $i => $p) {
            $ok = true;
            foreach ($pages as $j => $v)
                if ($ok) {
                    if (stripos($p, $v) !== false && $i != $j)
                        $ok = false;
                }
            if ($ok)
                $new[] = $p;
        }
        return $new;
    }

    /**
     * @param mixed $content
     * @param string $div
     * @param bool $fullLinks
     * 
     * @return [type]
     */
    public static function extractLinks($content, $div = "body", $fullLinks = false)
    {
        $p = \Pharse::str_get_dom($content);
        $links = array();
        if ($p) {
            $e = $p($div, 0);
            if ($e) {
                $elements = $e("a");
                if ($elements && is_array($elements))
                    foreach ($elements as $element) {
                        if ($fullLinks) {
                            $links[] = $element;
                        } else {
                            $links[] = $element->href;
                        }
                    }
            }
        }
        return $links;
    }

    /**
     * @param mixed $content
     * @param string $div
     * @param bool $fullLinks
     * 
     * @return [type]
     */
    public static function extractPhotos($content, $div = "body", $fullLinks = false)
    {
        $p = \Pharse::str_get_dom($content);
        $links = array();
        if ($p) {
            $e = $p($div, 0);
            if ($e) {
                $elements = $e("img");
                if ($elements && is_array($elements))
                    foreach ($elements as $element) {
                        if ($fullLinks) {
                            $links[] = $element;
                        } else {
                            $links[] = $element->src;
                        }
                    }
            }
        }
        return $links;
    }
}