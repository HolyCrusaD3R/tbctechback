<?php

namespace App\Libs;

use Exception;
use Illuminate\Support\Facades\Route;

class Symlink
{
	const STORAGE_LINK = 'storage';
	const SCRIPTS_LINK = 'scripts';
	const MARKUP_LINK = 'markup';

	protected array $folders;

	/**
	 * Symlink constructor.
	 */
	public function __construct()
	{
		$this->folders = [
			self::STORAGE_LINK => 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR .'public',
			self::SCRIPTS_LINK => 'scripts',
			self::MARKUP_LINK => 'markup',
		];
	}

	/**
	 * @throws Exception
	 */
	public function makeLinks(): void
    {

		$this->makeLink($this->getTargetDir(self::STORAGE_LINK), $this->getLinkDir(self::STORAGE_LINK));
//		$this->makeLink($this->getTargetDir(self::SCRIPTS_LINK), $this->getLinkDir(self::SCRIPTS_LINK));
//		$this->makeLink($this->getTargetDir(self::MARKUP_LINK), $this->getLinkDir(self::MARKUP_LINK));
	}

	/**
	 * @throws Exception
	 */
	public function checkLinks(): void
    {
		$this->checkLink($this->getLinkDir(self::STORAGE_LINK));
		$this->checkLink($this->getLinkDir(self::SCRIPTS_LINK));
		$this->checkLink($this->getLinkDir(self::MARKUP_LINK));
	}

	/**
	 *  get symlink routes
	 */
	public static function getRoute(): void
    {
		/* symlink */
		Route::get('/symlink/{check?}', function ($check = null) {
			$self = new self();
			try {
				if ($check) {
					$self->checkLinks();
					echo 'all links looks good';
				} else {
					$self->makeLinks();
					echo 'all links created';
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}

		});
	}

	/**
	 * @param $target
	 * @param $link
	 * @throws Exception
	 */
	protected function makeLink($target, $link): void
    {
		$this->deleteSymlink($link);
		if (!symlink($target, $link)) {
			throw new Exception($link . ' not created');
		}
	}

	/**
	 * @param $index
	 * @return string
	 */
	protected function getTargetDir($index): string
    {
		return base_path() . DIRECTORY_SEPARATOR . $this->folders[$index] . DIRECTORY_SEPARATOR;
	}

	/**
	 * @param $folder
	 * @return string
	 */
	protected function getLinkDir($folder): string
    {
		return public_path() . DIRECTORY_SEPARATOR . $folder;
	}

	/**
	 * @param $link
	 * @throws Exception
	 */
	protected function checkLink($link): void
    {
		if(is_link($link) && !file_exists($link)) {
			throw new Exception($link . ' - link is broken');
		} elseif (!file_exists($link)) {
			throw new Exception($link . ' - link not isset');
		}
	}

	/**
	 * @param $link
	 * @return bool
	 */
	protected function isLink($link): bool
    {
		return is_link($this->getLinkDir($link));
	}

	/**
	 * @param $link
	 */
	protected function deleteSymlink($link): void
    {
		if (file_exists($link)) {
			unlink($link);
		} elseif(is_link($link) && !file_exists($link)) {
			unlink($link);
		}
	}

}
