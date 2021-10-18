<?php

/**
 *  2Moons
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

class BBCode
{
    static public function parse($sText)
    {
        $sText = self::showBBcodes($sText);
        $sText = str_replace("\r\n", "\n", $sText);
        $sText = str_replace("\r", "\n", $sText);
        $sText = str_replace("\n", '<br />', $sText);
        return $sText;

        /*	    	$config = parse_ini_file('BBCodeParser2.ini', true);
                    $options = $config['HTML_BBCodeParser2'];

                    $parser = new HTML_BBCodeParser2($options);
                    $parser->setText($sText);
                    $parser->parse();
                    return $parser->getParsed();*/
    }

    public static function showBBcodes($text)
    {

        // NOTE : I had to update this sample code with below line to prevent obvious attacks as pointed out by many users.
        // Always ensure that user inputs are scanned and filtered properly.
        $text = htmlspecialchars($text, ENT_QUOTES);

        // BBcode array
        $find = array(
            '~\[b\](.*?)\[/b\]~s',
            '~\[i\](.*?)\[/i\]~s',
            '~\[u\](.*?)\[/u\]~s',
            '~\[quote\](.*?)\[/quote\]~s',
            '~\[size=(.*?)\](.*?)\[/size\]~s',
            '~\[color=(.*?)\](.*?)\[/color\]~s',
            '~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
            '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
        );

        // HTML tags to replace BBcode
        $replace = array(
            '<b>$1</b>',
            '<i>$1</i>',
            '<span style="text-decoration:underline;">$1</span>',
            '<pre>$1</' . 'pre>',
            '<span style="font-size:$1px;">$2</span>',
            '<span style="color:$1;">$2</span>',
            '<a href="$1">$1</a>',
            '<img src="$1" alt="" />'
        );

        // Replacing the BBcodes with corresponding HTML tags
        return preg_replace($find, $replace, $text);
    }
}
