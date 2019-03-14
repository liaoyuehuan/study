<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2018/12/12
 * Time: 15:05
 */

namespace Xl;

class LibReOffice
{
    const PID_FILE_PREFIX = "office_";

    const TEMP_FILE_PREFIX = "office_"; // Windows uses only the first three characters of prefix.

    protected static $allowExtension = [
        'pdf',
        'pdf:writer_pdf_Export',
        'html',
        'docx:"MS Word 2007 XML"'
    ];

    /**
     * @var array
     */
    private $config = [
        'cmd' => '/usr/bin/soffice',
        'use_pid_file' => false,
        'out_dir' => '/tmp', // 生成成功后文件的保存目录
        'output_file_extension' => 'pdf',
        'temp_dir' => null // 保存文件的临时目录(默认系统来自系统临时目录)
    ];

    /**
     * @var array
     */
    private $defaultOptions = [
        '--headless',
        '--invisible'
    ];

    /**
     * @var string
     */
    private $tempFile;

    /**
     * @var string
     */
    private $pidFile;

    /**
     * @return array
     */
    public static function getAllowExtension()
    {
        return self::$allowExtension;
    }

    /**
     * @return string
     */
    protected static function generalUniquePidFileName()
    {
        return uniqid(self::PID_FILE_PREFIX);
    }

    /**
     * @param $fileData string
     * @param array $config
     * @return LibReOffice
     * @throws \Exception
     */
    public static function newLibReOffice($fileData, $config = [])
    {
        return new static($fileData, $config);
    }

    /**
     * LibReOffice constructor.
     * @param $fileData string
     * @param array $config
     * @throws \Exception
     */
    public function __construct($fileData, $config = [])
    {
        if (isset($config['output_file_extension'])) {
            if (in_array($config['output_file_extension'], static::$allowExtension)) {
                throw new \Exception('output_file_extension is not allow');
            }
        }
        $this->config = array_merge($this->config, $this->config);
        $this->loadFileData($fileData);
    }

    /**
     * @param $fileData string
     * @throws \Exception
     */
    public function loadFileData($fileData)
    {
        $tempFile = tempnam($this->getTempDir(), static::TEMP_FILE_PREFIX);
        if (!$tempFile) {
            throw  new \Exception('create temp file error');
        }
        file_put_contents($tempFile, $fileData);
        $this->tempFile = $tempFile;
    }


    /**
     * @param $outputFileExtension string
     */
    public function setOutputFileExtension($outputFileExtension)
    {
        $this->config['output_file_extension'] = $outputFileExtension;
    }

    public function setPdfToWord(){
        $this->defaultOptions[] = '--infilter="writer_pdf_import"';
        $this->setOutputFileExtension('doc');
    }

    public function buildCmd()
    {
        if ($this->config['use_pid_file'] === true) {
            return sprintf('%s %s --pidfile =%s  --convert-to %s --outdir "%s" "%s" ',
                $this->config['cmd'],
                implode(' ', $this->defaultOptions),
                $this->getPidFile(),
                $this->config['output_file_extension'],
                $this->getOutDir(),
                $this->tempFile
            );
        } else {
            return sprintf('%s %s --convert-to %s --outdir "%s" "%s" ',
                $this->config['cmd'],
                implode(' ', $this->defaultOptions),
                $this->config['output_file_extension'],
                $this->getOutDir(),
                $this->tempFile
            );
        }
    }

    /**
     * @return bool|string
     */
    public function getPid()
    {
        if ($this->config['use_pid_file'] === true && is_file($this->pidFile)) {
            return file_get_contents($this->pidFile);
        } else {
            return false;
        }
    }

    protected function getPidFile()
    {
        if (empty($this->pidFile)) {
            $this->pidFile = static::generalUniquePidFileName();
        }
        return $this->pidFile;
    }

    /**
     * @return string
     */
    public function getOutputFile()
    {
        return rtrim($this->getOutDir(), '/') . '/' . basename($this->tempFile);
    }

    /**
     * @return string
     */
    protected function getOutDir()
    {
        if ($this->config['out_dir'] && is_dir($this->config['out_dir'])) {
            return $this->config['out_dir'];
        } else {
            return sys_get_temp_dir();
        }
    }

    /**
     * @return string
     */
    protected function getTempDir()
    {
        if ($this->config['temp_dir'] && is_dir($this->config['temp_dir'])) {
            return $this->config['temp_dir'];
        } else {
            return sys_get_temp_dir();
        }
    }

    /**
     * 说明：执行成功后返回保存文件的路径
     * @return string
     * @throws \Exception
     */
    public function run()
    {
        $command = $this->buildCmd();
        $result = system($command, $return_var);
        if (0 !== $return_var) {
            throw new \Exception($result);
        }
        return $this->getOutputFile();
    }

}