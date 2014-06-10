<?php
class Assets extends \Chibi\Util\Assets
{
	private $pageThumbnail = null;
	private $subTitle = null;

	public function setSubTitle($text)
	{
		$this->subTitle = $text;
	}

	public function setPageThumbnail($path)
	{
		$this->pageThumbnail = $path;
	}

	public function addStylesheet($path)
	{
		return $this->addStylesheetFullPath($this->decorateUrl('/media/css/' . $path));
	}

	public function addStylesheetFullPath($path)
	{
		return parent::addStylesheet($path);
	}

	public function addScript($path)
	{
		return $this->addScriptFullPath($this->decorateUrl('/media/js/' . $path));
	}

	public function addScriptFullPath($path)
	{
		return parent::addScript($path);
	}

	public function transformHtml($html)
	{
		$this->title = isset($this->subTitle)
			? sprintf('%s&nbsp;&ndash;&nbsp;%s', $this->title, $this->subTitle)
			: $this->title;

		$html = parent::transformHtml($html);

		$headSnippet = '<meta property="og:title" content="' . $this->title . '"/>';
		$headSnippet .= '<meta property="og:url" content="' . \Chibi\Util\Url::currentUrl() . '"/>';
		if (!empty($this->pageThumbnail))
			$headSnippet .= '<meta property="og:image" content="' . $this->pageThumbnail . '"/>';

		$bodySnippet = '<script type="text/javascript">';
		$bodySnippet .= '$(function() {';
		$bodySnippet .= '$(\'body\').trigger(\'dom-update\');';
		$bodySnippet .= '});';
		$bodySnippet .= '</script>';

		$html = str_replace('</head>', $headSnippet . '</head>', $html);
		$html = str_replace('</body>', $bodySnippet . '</body>', $html);
		return $html;
	}


	private function decorateUrl($url)
	{
		return $url . '?' . PropertyModel::get(PropertyModel::EngineVersion);
	}
}
