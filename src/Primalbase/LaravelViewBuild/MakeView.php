<?php namespace Primalbase\LaravelViewBuild;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeView extends CommandBase {

  protected $name = 'view:make';

  protected $description = 'make view via dwt.';

  public function fire()
  {
    $view   = $this->argument('view');
    $source = $this->argument('source');
    $layout = $this->option('layout');
    $engine = $this->option('engine');
    $makeBase = !$this->option('no-base');

    $viewPath = $this->getViewPath($view, $makeBase);
    if (!$viewPath)
      return;

    $sourcePath = $this->getSourcePath($source, false);
    if (!$sourcePath)
      return;

    $baseView = $this->getBaseView($view);

    $dwtLayout = $this->getDwtLayout($source, $viewPath, $layout, $makeBase, $baseView, 'view');
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
