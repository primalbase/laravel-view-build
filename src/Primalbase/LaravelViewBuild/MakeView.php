<?php namespace Primalbase\LaravelViewBuild;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeView extends CommandBase {

  protected $name = 'view:make';

  protected $description = 'make view via dwt.';

  public function fire()
  {
    $config = $this->getConfig();

    $view   = $this->argument('view');
    $source = $this->argument('source');
    $layout = $this->option('layout');
    $engine = $this->option('engine');
    $noBase = $this->option('no-base');

    $viewPath = $this->getViewPath($view);
    if ($noBase && file_exists($viewPath))
    {
      if (!$this->confirm('file exists. overwrite?[y/N]'))
      {
        $this->info('canceled.');
        return;
      }
    }

    if (preg_match('/^(.*[\:\.])([^.:]+)$/', $view, $m))
    {
      $baseView = $m[1].'base.'.$m[2];
    }
    else
    {
      $baseView = 'base.'.$view;
    }

    if (!file_exists(public_path($source)))
    {
      $this->error($source.' file not found.');
      return;
    }
    $dwtLayout = new DwtLayout($config['views_path'], $engine);
    $dwtLayout->setOutputPath($viewPath);
    $dwtLayout->setLayout($layout);
    $dwtLayout->setSource($source);
    $dwtLayout->setBaseView($baseView);
    $dwtLayout->setEnabledMakeBase(!$noBase);
    $dwtLayout->setDocumentRoot(public_path());
    $dwtLayout->setStyle('view');
    $dwtLayout->save($engine);
    $this->info('saved to '.$dwtLayout->saved());
  }

  protected function getArguments()
  {
    return [
      ['source', InputArgument::REQUIRED, 'source html file path(e.g.,index.html).'],
      ['view', InputArgument::REQUIRED, 'view argument required(e.g.,home.index).'],
    ];
  }

  protected function getOptions()
  {
    return [
      ['layout', null, InputOption::VALUE_OPTIONAL, 'layout view(e.g.,layout.main).', 'layout.main'],
      ['engine', null, InputOption::VALUE_OPTIONAL, 'template engine(blade|twig).', 'blade'],
      ['no-base', null, InputOption::VALUE_NONE, 'no make base file'],
    ];
  }

}
