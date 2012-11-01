#!/usr/bin/php
<?
/*
	Create patch from 2 different comntent of git repo branch
*/
class PatchCreator
{
	private $branch1;
	private $branch2;
	private $repoDir;
	private $outputFolder;

	public function __construct($branch1, $branch2, $repoDir, $outputFolder)
	{
		$this->branch1 = $branch1;
		$this->branch2 = $branch2;
		$this->repoDir = $repoDir;
		$this->outputFolder = $outputFolder;
		$this->createPatch();
	}


	protected function createPatch()
	{
		exec("git --git-dir=" . $this->repoDir . "/.git --work-tree=" . $this->repoDir . " diff --name-only ".$this->branch1." ".$this->branch2, $output);
		if($output)
		{
			foreach($output as $item)
			{
				$info = pathinfo($item);
				echo $this->outputFolder."/".$info['dirname'] ."/". $info['basename']."\n";
				if(!file_exists($this->outputFolder . "/" . $info['dirname']))
				{
					mkdir($this->outputFolder . "/" . $info['dirname'], 0777, true);
				}
				if(is_file($this->repoDir . "/" . $info['dirname'] . "/" . $info['basename']))
				{
					copy($this->repoDir . "/" . $info['dirname'] . "/" . $info['basename'], $this->outputFolder . "/" . $info['dirname'] . "/" . $info['basename']);
				}
			}
		}
	}

}


/*
if(count($argv)>=4)
{
	$creator = new PatchCreator($argv[1], $argv[2], $argv[3], $argv[4]);
}
else
{
	echo "Please add more params!\n";
}
*/
$c = new PatchCreator('master', 'examplebranch','/home/example/test','./patch');
?>
