<?php

namespace Marsgen\Commands;

use Marsgen\Libs\MarsgenParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command {
    
    protected function configure()
    {
        $this
        ->setName('generate')
        ->setDescription('Generate files')
        ->addArgument('source', InputArgument::REQUIRED, 'Source folder')
        ->addArgument('seed', InputArgument::OPTIONAL, 'Seed file (To ignore use dash: - )')
        ->addArgument('target', InputArgument::OPTIONAL, 'Destination folder (Default is current working directory.)');
    }//configure
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('----------');

        $source 	= $input->getArgument('source');
        $target 	= $input->getArgument('target');
        $seed 		= $input->getArgument('seed');
        $source 	= str_replace('/', '\\', getcwd().$source);
        $target 	= str_replace('/', '\\', getcwd().$target);
        $seedfile	= str_replace('/', '\\', getcwd().$seed);
        $seeddata   = array();
        
        /*
        * Write info
        */
        $output->writeln('Source forlder: '.$source);
        $output->writeln('Target forlder: '.$target);
        $output->writeln('Seed file: '.$seedfile);
        
        /*
        * Prepare
        */
        if(file_exists($seedfile)){
                $this->seeddata = require($seedfile);
            }else{
                if($seed != '-') die('Seed File is not found!');
            }
        if(!is_dir($source)){die('Source folder is not found!');}
        
        /*
        * Get file list from template
        */
        $filelist = $this->filelist($source);
        
        /*
        * Create folders for destination
        */
        //Create target folder if not exist
        if(!is_dir($target)){
            mkdir($target);
        $output->writeln('Destination folder is created.');}
        //Create template folders if not generated
        foreach ($filelist['folders'] as $value) {
            $newFolder = $target . $this->fileRename(substr($value,strlen($source)));
            if(!is_dir($newFolder)) {
                mkdir($newFolder);
                $output->writeln('Folder created: "' . substr($newFolder,strlen($target)) . '"');
            }else{
                $output->writeln('The folder "' . substr($newFolder,strlen($target)) . '" is already exists');
            }
        };
        
        /*
        * Create files
        */
        foreach ($filelist['files'] as $value) {
            $content = file_get_contents($value);
            $parser = new MarsgenParser($content,$this->seeddata);
            $put_location = $target . $this->fileRename(substr($value,strlen($source)));
            file_put_contents($put_location, $parser->parse());
            $output->writeln('The file: "' . $this->fileRename(substr($put_location,strlen($target))) . '" is generated');
        }

        $output->writeln('----------');
    }//execute

    protected function fileRename($filename){
        if (isset($this->seeddata['__FileSystem__'])){
            foreach ($this->seeddata['__FileSystem__'] as $key => $value) {
                $filename = str_replace($key, $value, $filename);
            }
        }
        return $filename;
    }
    
    /**
    * fileList
    *
    * @param [type] $dir
    * @param array $results
    * @return void
    */
    protected function fileList($dir, &$results = array()){
        $files = scandir($dir);
        foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if(!is_dir($path)) {
                $results['files'][]= $path;
            } else if($value != "." && $value != "..") {
                $results['folders'][] = $path;
                $this->filelist($path, $results);
            }
        }
        return $results;
    }//filelist
    
}//class