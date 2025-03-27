<?php

namespace Nilgems\PhpTextract\ExtractorService\Options;

use Nilgems\PhpTextract\ExtractorService\Options\Contracts\AbstractOptions;

class PdfOptions extends AbstractOptions
{
    /**
     * Specifies the first page to convert.
     * @var int|null $firstPage
     */
    public ?int $firstPage = null;
    /**
     * Specifies the last page to convert.
     * @var int|null $lastPage
     */
    public ?int $lastPage = null;
    /**
     * Specifies the resolution, in DPI.  The default is 72 DPI.
     * @var int|null $resolution
     */
    public ?int $resolution = null;
    /**
     * Specifies the x-coordinate of the crop area top left corner
     * @var int|null
     */
    public ?int $xCoordinate = null;
    /**
     * Specifies the y-coordinate of the crop area top left corner
     * @var int|null $yCoordinate
     */
    public ?int $yCoordinate = null;
    /**
     * Specifies the width of crop area in pixels (default is 0)
     * @var int|null
     */
    public ?int $widthOfCorpArea = null;
    /**
     * Specifies the height of crop area in pixels (default is 0)
     * @var int|null
     */
    public ?int $heightOfCorpArea = null;
    /**
     * Maintain (as best as possible) the original physical layout of the text.  The default is to ´undo'
     * physical layout (columns, hyphenation, etc.) and output the text in reading order.
     * @var bool $layoutModeEnabled
     */
    public bool $layoutModeEnabled = false;

    /**
     * Assume fixed-pitch (or tabular) text, with the specified character width (in points).  This forces
     * physical layout mode.
     * @var int|null $fixedPitch
     */
    public ?int $fixedPitch = null;
    /**
     * Keep the text in content stream order.  This is a hack which  often  "undoes"  column  formatting,
     * etc.  Use of raw mode is no longer recommended.
     * @var bool $rawEnabled
     */
    public bool $rawEnabled = false;
    /**
     * Sets the encoding to use for text output. This defaults to "UTF-8".
     * @var string|null $encodingName
     */
    public ?string $encodingName = null;
    /**
     * Don't insert page breaks (form feed characters) between pages.
     * @var bool $pdfNoPageBreaks
     */
    public bool $noPageBreaksEnabled = false;
    /**
     * Specify  the  owner  password  for  the  PDF  file.   Providing  this  will  bypass  all  security
     * restrictions.
     * @var string|null $ownerPassword
     */
    public ?string $ownerPassword = null;
    /**
     * Specify the user password for the PDF file.
     * @var string|null $userPassword
     */
    public ?string $userPassword = null;



    /**
     * Specifies the first page to convert.
     * @param int $pageNo
     * @return $this
     */
    public function addFirstPage(int $pageNo): static
    {
        $this->firstPage = $pageNo;
        return $this;
    }

    /**
     * Specifies the last page to convert.
     * @param int $pageNo
     * @return $this
     */
    public function addLastPage(int $pageNo): static
    {
        $this->lastPage = $pageNo;
        return $this;
    }

    /**
     * Specifies the resolution, in DPI.  The default is 72 DPI.
     * @param int $resolution
     * @return $this
     */
    public function addResolution(int $resolution): static
    {
        $this->resolution = $resolution;
        return $this;
    }

    /**
     * Specifies the x-coordinate of the crop area top left corner
     * @param int $xCoordinate
     * @return $this
     */
    public function addXCoordinate(int $xCoordinate): static
    {
        $this->xCoordinate = $xCoordinate;
        return $this;
    }

    /**
     * Specifies the y-coordinate of the crop area top left corner
     * @param int $yCoordinate
     * @return $this
     */
    public function addYCoordinate(int $yCoordinate): static
    {
        $this->yCoordinate = $yCoordinate;
        return $this;
    }

    /**
     * Specifies the width of crop area in pixels (default is 0)
     * @param int $width
     * @return $this
     */
    public function addWidthOfCorpArea(int $width): static
    {
        $this->widthOfCorpArea = $width;
        return $this;
    }

    /**
     * Specifies the height of crop area in pixels (default is 0)
     * @param int $height
     * @return $this
     */
    public function addHeightOfCorpArea(int $height): static
    {
        $this->heightOfCorpArea = $height;
        return $this;
    }

    /**
     * Maintain (as best as possible) the original physical layout of the text.  The default is to ´undo'
     * physical layout (columns, hyphenation, etc.) and output the text in reading order.
     * @return $this
     */
    public function useLayoutMode(): static
    {
        $this->layoutModeEnabled = true;
        return $this;
    }

    /**
     * Assume fixed-pitch (or tabular) text, with the specified character width (in points).  This forces
     * physical layout mode.
     * @param int $pitch
     * @return $this
     */
    public function addFixedPitch(int $pitch): static
    {
        $this->fixedPitch = $pitch;
        return $this;
    }

    /**
     * Keep the text in content stream order.  This is a hack which  often  "undoes"  column  formatting,
     * etc.  Use of raw mode is no longer recommended.
     * @return $this
     */
    public function useRaw(): static
    {
        $this->rawEnabled = true;
        return $this;
    }

    /**
     * Sets the encoding to use for text output. This defaults to "UTF-8".
     * @param string $encodingName
     * @return $this
     */
    public function addEncodingName(string $encodingName): static
    {
        $this->encodingName = $encodingName;
        return $this;
    }

    /**
     * Don't insert page breaks (form feed characters) between pages.
     * @return $this
     */
    public function useNoPageBreak(): static
    {
        $this->noPageBreaksEnabled = true;
        return $this;
    }

    /**
     * Specify  the  owner  password  for  the  PDF  file.   Providing  this  will  bypass  all  security
     * restrictions.
     * @param string $password
     * @return $this
     */
    public function addOwnerPassword(string $password): static
    {
        $this->ownerPassword = $password;
        return $this;
    }

    /**
     * Specify the user password for the PDF file.
     * @param string $password
     * @return $this
     */
    public function addUserPassword(string $password): static
    {
        $this->userPassword = $password;
        return $this;
    }
}