<?php
declare(strict_types=1);

namespace dfkgw\MimeFoldFlowedText;

use \PHPUnit\Framework\TestCase;

final class FlowingTextTest extends TestCase
{
    private static function join(array $lines = [], string $encoding = null)
    {
        $EOL = "\r\n";
        $text = join($EOL, $lines);
        if (!empty($encoding)) {
            $text = mb_convert_encoding($text, $encoding, 'UTF-8');
        }
        return $text;
    }

    public function testConstructFlowingText(): void
    {
        $x = new FlowingText();
        $this->assertInstanceOf(FlowingText::class, $x);
    }

    public function testCanFoldText_en_1(): void
    {
        $EOL = "\r\n";
        $text = str_repeat('hello ', 20);
        $actual = FlowingText::fold($text);
        $expected = str_repeat('hello ', 12) . $EOL . str_repeat('hello ', 7) . 'hello';
        $this->assertEquals($expected, $actual);
    }

    public function testCanFoldText_en_2(): void
    {
        $text = self::join(['abcdef x x x', 'abcde x x x', 'abcd x x x']);
        $width = 8;
        $actual = FlowingText::fold($text, $width);
        $expected = self::join(['abcdef ', 'x x x', 'abcde x ', 'x x', 'abcd x ', 'x x']);
        $this->assertEquals($expected, $actual);
    }

    public function testCanFoldText_utf8_1(): void
    {
        $text = self::join(['abčdef x x x', 'abčde x x x', 'abčd x x x']);
        $width = 8;
        $actual = FlowingText::fold($text, $width);
        $expected = self::join(['abčdef ', 'x x x', 'abčde ', 'x x x', 'abčd x ', 'x x']);
        $this->assertEquals($expected, $actual);
    }

    public function testCanFoldText_utf8_delsp_1(): void
    {
        $text = 'あいうえおかきくけこ';
        $width = 10;
        $encoding = 'UTF-8';
        $delsp = true;
        $actual = FlowingText::fold($text, $width, $encoding, $delsp);
        $expected = self::join(['あいう ', 'えおか ', 'きくけ ', 'こ']);
        $this->assertEquals($expected, $actual);
    }

    public function testCanFoldText_utf8_delsp_2(): void
    {
        $text = self::join(['あいうえお', 'かきくけこさ']);
        $width = 9;
        $encoding = 'UTF-8';
        $delsp = true;
        $actual = FlowingText::fold($text, $width, $encoding, $delsp);
        $expected = self::join(['あい ', 'うえお', 'かき ', 'くけ ', 'こさ']);
        $this->assertEquals($expected, $actual);
    }

    public function testCanFoldText_utf8_delsp_3(): void
    {
        $text = self::join(['あああxxxxx', 'ああxxxxxあ', 'あxxxxxああ']);
        $width = 12;
        $encoding = 'UTF-8';
        $delsp = true;
        $actual = FlowingText::fold($text, $width, $encoding, $delsp);
        $expected = self::join(['あああ ', 'xxxxx', 'ああxxxxx ', 'あ', 'あxxxxxあ ', 'あ']);
        $this->assertEquals($expected, $actual);
    }

    public function testCanFoldQuote_utf8_delsp_1(): void
    {
        $text = '> あいうえおかきくけこ';
        $width = 12;
        $encoding = 'UTF-8';
        $delsp = true;
        $actual = FlowingText::fold($text, $width, $encoding, $delsp);
        $expected = self::join(['> あいう ', '> えおか ', '> きくけ ', '> こ']);
        $this->assertEquals($expected, $actual);
    }

    public function testCanFoldText_jis_delsp_1(): void
    {
        $encoding = 'ISO-2022-JP';
        $text = self::join(['あいうえおかきくけこ'], $encoding);
        $width = 16;
        $delsp = true;
        $actual = FlowingText::fold($text, $width, $encoding, $delsp);
        $expected = self::join(['あいうえ ', 'おかきく ', 'けこ'], $encoding);
        $this->assertEquals($expected, $actual);
    }

    public function testCanFoldText_jis_delsp_2(): void
    {
        $encoding = 'ISO-2022-JP';
        $text = self::join(['あいうえお', 'かきくけこさ'], $encoding);
        $width = 16;
        $delsp = true;
        $actual = FlowingText::fold($text, $width, $encoding, $delsp);
        $expected = self::join(['あいうえお', 'かきくけ ', 'こさ'], $encoding);
        $this->assertEquals($expected, $actual);
    }

    public function testCanFoldText_jis_delsp_3(): void
    {
        $encoding = 'ISO-2022-JP';
        $text = self::join(['あああxxxxx', 'ああxxxxxあ', 'あxxxxxああ'], $encoding);
        $width = 16;
        $delsp = true;
        $actual = FlowingText::fold($text, $width, $encoding, $delsp);
        $expected = self::join(['あああ ', 'xxxxx', 'ああxxxxx ', 'あ', 'あxxxxx ', 'ああ'], $encoding);
        $this->assertEquals($expected, $actual);
    }







}
