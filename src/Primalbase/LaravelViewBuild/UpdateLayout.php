<?php namespace Primalbase\LaravelViewBuild;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class UpdateLayout extends CommandBase {

  protected $name = 'layout:update';

  protected $description = 'DreamWeaver Template(.dwt) convert to any template.';

  public function fire()
  {
    $config = $this->getConfig();

    $source = $this->option('source');
    $layout = $this->option('layout');
    $engine = $this->option('engine');
    $noBase = $this->option('no-base');

    if (preg_match('/^(.*[\:\.])([^.:]+)$/', $layout, $m))
    {
      $baseView = $m[1].'base.'.$m[2];
    }
    else
    {
      $baseView = 'base.'.$layout;
    }

    $viewPath = $this->getViewPath($layout);
    $dwtLayout = new DwtLayout;
    $dwtLayout->setOutputPath($viewPath);
    $dwtLayout->setLayout($layout);
    $dwtLayout->setSource($config['templates_dir'].'/'.$source);
    $dwtLayout->setEnabledMakeBase(!$noBase);
    $dwtLayout->setBaseView($baseView);
    $dwtLayout->setDocumentRoot(public_path());
    $dwtLayout->save($engine);
    $this->info('saved to '.$dwtLayout->saved());
  }

  protected function getArguments()
  {
    return [];
  }

  protected function getOptions()
  {
    return [
      ['source', null, InputOption::VALUE_OPTIONAL, 'source dwt file path(e.g.,main).', 'main.dwt'],
      ['layout', null, InputOption::VALUE_OPTIONAL, 'layout view(e.g.,layout.main).', 'layout.main'],
      ['engine', null, InputOption::VALUE_OPTIONAL, 'template engine(blade|twig).', 'blade'],
      ['no-base', null, InputOption::VALUE_NONE, 'no make base file'],
    ];
  }

}
