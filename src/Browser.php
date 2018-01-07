<?php
namespace Its404\PhpPuppeteer;

class Browser
{
    // Puppeteer configuration items
    private $config;
    
    // parameters to run node command
    public $path;               // path
    public $nodePath;           // node path
    public $nodeBinary;
    public $executable;        // executable js to call ruppeteer api
    
    public $isDebug;    // show detailed output from exec command
    
    public function __construct()
    {
        $this->config = [];
        // default config
        $this->config['goto']['waitUntil'] = ['load', 'domcontentloaded', 'networkidle0', 'networkidle2'];
        $this->config['viewport']['width'] = 1024;
        $this->config['viewport']['height'] = 800;
        
        $this->path = 'PATH=$PATH:/usr/local/bin';
        $this->nodePath = 'NODE_PATH=`npm root -g`';
        $this->nodeBinary = 'node';
        $this->executable = __DIR__.'/js/puppeteer-api.js';
        
        $this->isDebug = false;
    }
    
    /**
     * Generate PDF file based on configuration.
     * 
     * @param array $config configuration for PDF generation, this will override default configuration.
     * 
     * Sample $config
     * ```
     * $config = [
     *      'html' => '<h1>Hello World</h1>',
     *      'pdf' => [
     *          'path' => '/tmp/test.pdf',
     *          'margin' => [
     *              'top' => '10mm',
     *              'right' => '10mm',
     *              'bottom' => '10mm',
     *              'left' => '10mm',
     *          ]
     *      ]
     *  ];
     * ```
     * 
     *  1. Must set either $config['url'] or $config['html'], if both, will pick up html.
     *  2. If $config['pdf']['path'] is set, will generate PDF file to the specific path, 
     *      otherwise, will return PDF data.
     * 
     * @return mixed property value
     *  1. array $result when $config['pdf']['path'] is set or the `command` is not running successfully,
     *     $result includes output of command and a return value, you can use $result['returnVal'] to check restult,
     *     $result['returnVal'] == 0 means pdf is generated successfully, else find detailed error from $result['ouput'];
     *  2. PDF data, this is returned only when $config['pdf']['path'] is not set.
     * */
    public function pdf($config = [])
    {
        if (!isset($config['url']) && !isset($config['html'])) {
            throw new \Exception('URL or HTML in configuration required', 400);
        }
        $tempFile = null;
        if (!isset($config['pdf']['path'])) {
            $tempFile = tempnam(sys_get_temp_dir(), 'pdf-');
            $this->config['pdf']['path'] = $tempFile;
        }
        // default PDF configuration
        $this->config['pdf']['format'] = 'A4';
        $this->config['pdf']['printBackground'] = true;
        
        $this->config = self::merge($this->config, $config);
        $fullCommand = $this->path.' ' .$this->nodePath.' ' .$this->nodeBinary.' '
            .escapeshellarg($this->executable). ' ' .escapeshellarg(json_encode($this->config));
            
        if ($this->isDebug) {
            $fullCommand .= " 2>&1";
        }
        exec($fullCommand, $output, $returnVal);
        $result = [
            'ouput' => $output,
            'returnVal' => $returnVal
        ];
        if ($returnVal == 0 && isset($tempFile)) {
            $data = file_get_contents($this->config['pdf']['path']);
            unlink($this->config['pdf']['path']);
            return $data;
        }
        
        return $result;
    }
    
    private static function merge($a, $b)
    {
        $res = $a;
        foreach ($b as $k => $v) {
            if (is_int($k)) {
                if (array_key_exists($k, $res)) {
                    $res[] = $v;
                } else {
                    $res[$k] = $v;
                }
            } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                $res[$k] = self::merge($res[$k], $v);
            } else {
                $res[$k] = $v;
            }
        }
        return $res;
    }
}