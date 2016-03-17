<?php namespace Primalbase\LaravelViewBuild;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class UpdateLayout extends CommandBase {

  protected $name = 'layout:update';

  protected $description = 'DreamWeaver Template(.dwt) convert to any template.';

  public function fire()
  {
    $source   = $this->option('source');
    $layout   = $this->option('layout');
    $engine   = $this->option('engine');
    $makeBase = !$this->option('no-base');

    $viewPath = $this->getViewPath($layout, $makeBase);
    if (!$viewPath)
      return;

    $sourcePath = $this->getSourcePath($source);
    if (!$sourcePath)
      return;

    $baseView = $this->getBaseView($layout);

    $dwtLayout = $this->getDwtLayout($sourcePath, $viewPath, $layout, $makeBase, $baseView, 'layout');
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
