<?php
/**
 * @var $this \view\FilesRowsView
 */
?>

        <tr>
            <td style="white-space: nowrap">
                <span class="<?=$this->getIcon()?>">

                </span>

                <a class="files-link-res<?=$this->getCssClass()?>" data-path="<?=$this->getPath()?>" data-ajax-href="<?=$this->getAjaxLink()?>" href="<?=$this->getLink()?>">
                    <?=$this->getName()?>
                </a>
            </td>
            <td style="white-space: nowrap">
                <?=$this->getType()?>
            </td>
            <td style="white-space: nowrap">
                <time class="timeago" datetime="<?=$this->getLastChange()?>"><?=$this->getLastChangeHumanReadable()?></time>
            </td>
            <td style="white-space: nowrap">
                <span class="filesize"><?=$this->getSize()?></span>
            </td>
        </tr>
