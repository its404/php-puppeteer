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
        
        $this->path = 'PATH=$PATH:/usr/local/bin';
        $this->nodePath = 'NODE_PATH=`npm root -g`';
        $this->nodeBinary = 'node';
        $this->executable = __DIR__.'/js/puppeteer-api.js';
        
        $this->isDebug = false;
    }
    
    public function pdf($config = [])
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'pdf-');
        $this->config['pdf']['path'] = $tempFile;
        $this->config = self::merge($this->config, $config);
        $fullCommand = $this->path.' ' .$this->nodePath.' ' .$this->nodeBinary.' '
            .escapeshellarg($this->executable). ' ' .escapeshellarg(json_encode($this->config));
            
            if ($this->isDebug) {
                $fullCommand .= " 2>&1";
            }
		exec($fullCommand, $output, $returnVal);
		if ($returnVal == 0) {
			$data = file_get_contents($this->config['pdf']['path']);
			unlink($this->config['pdf']['path']);
			return $data;
		} else {
			return [
				'ouput' => $output,
				'returnVal' => $returnVal
			];
		}
    }
    /**
     * @var $margin array
     * [
     'top' => '10mm',
     'right' => '10mm',
     'bottom' => '10mm',
     'left' => '10mm',
     * ]
     * */
    public function setMargin($margin)
    {
        $this->config = self::merge($this->config, [
            'pdf' => [
                'margin' => $margin
            ]]);
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