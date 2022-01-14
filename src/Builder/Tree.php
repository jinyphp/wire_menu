<?php
namespace Jiny\Menu\Builder;
use \Jiny\Html\CTag;
/**
 *  Tree UL을 생성합니다.
 */
class Tree
{
    private $tree;
    public function __construct($tree)
    {
        $this->tree = $tree;
    }

    public function make()
    {
        $ul = $this->ul($this->tree, ['ref'=>0]);
        $ul->addClass('root');
        return $ul;
    }

    private function btnCreateLi($item)
    {
        $li = new \Jiny\Html\CTag('li',true);
        $li->addItem($this->btnSubMenu($item['ref']));
        $li->addItem("서브메뉴 생성 또는 tree를 드래그 하세요.");
        $li->addClass("create");
        $li->addClass("bg-gray-100");
        return $li;
    }

    private function ul($tree, $item)
    {
        $ul = new CTag('ul', true);

        // 서브트리 생성 버튼
        $ul->addFirstItem($this->btnCreateLi($item));

        foreach($tree as $item) {
            $li = $this->li($item);
            $ul->addItem($li);
        }
        return $ul;
    }


    private function li($item)
    {
        $li = new CTag('li', true);

        $li->setAttribute('data-id', $item['id']);
        $li->setAttribute('data-level', $item['level']);
        $li->setAttribute('data-ref', $item['ref']);
        $li->setAttribute('data-pos', $item['pos']);

        $li->setAttribute('draggable', "true");
        $li->addClass('drag-node');

        $content = $this->content($item);
        $li->addItem($content);

        // 서브트리 재귀호출
        if(isset($item['sub'])) {
            $li->addItem($this->ul($item['sub'], $item));
        } else {
            $ul = new CTag('ul', true);
            // 서브트리 생성 버튼
            $ul->addFirstItem($this->btnCreateLi($item));
            $li->addItem($ul);
        }

        return $li;
    }

    private function content($item)
    {
        $_a = new CTag('a',true);


        $icon_plus = xIcon($name="plus-circle-dotted", $type="bootstrap")->setClass("w-3 h-3");

        $icon_up = xIcon($name="caret-up", $type="bootstrap")->setClass("w-3 h-3 inline-block");
        $icon_down = xIcon($name="caret-down", $type="bootstrap")->setClass("w-3 h-3 inline-block");


        ##
        $leftBox = xDiv();

        //$icon_arrow = xIcon("corner-down-right")->setType("tabler-icons")->setClass("w-4 h-4 inline-block -mt-2");
        //$leftBox->addItem($icon_arrow);

        // 위치정보

        $leftBox->addItem( "Id:".$item['id']."/"."ref:".$item['ref']."/" );


        // 메뉴 수정링크
        $link = (clone $_a)
            ->addItem($item['title'])
            ->setAttribute('href', "javascript: void(0);");
        $link->setAttribute("wire:click", "$"."emit('edit','".$item['id']."')");
        $leftBox->addItem( xEnableText($item, $link) );


        // 하위 생성 버튼
        /*
        $create = (clone $_a)
            ->addItem( $icon_plus )
            ->setAttribute('wire:click',"$"."emit('popupFormCreate','".$item['id']."')");
        $create->addClass("px-2");
        $leftBox->addItem($create);
        */


        // 상위이동
        $leftBox->addItem(
            (clone $_a)
            ->addItem( $icon_up )
            ->setAttribute('wire:click',"move_up('".$item['id']."')")
            ->setAttribute('href', "javascript: void(0);")
        );

        // 하위이동
        $leftBox->addItem(
            (clone $_a)
            ->addItem( $icon_down )
            ->setAttribute('wire:click',"move_down('".$item['id']."')")
            ->setAttribute('href', "javascript: void(0);")
        );

        $leftBox->addItem($item['href']);

        /*
        $leftBox->addItem($item['href']);
        $leftBox->addItem($item['description']);

        $leftBox->addClass("title");
        return $leftBox;
        */

        $rightBox = xDiv();

        $rightBox->addItem($item['description']);
        $rightBox->addClass("title-right");

        // flex box로 출력
        $flexbox = new CTag('div', true);
        $flexbox->addClass("title flex justify-between");
        $flexbox->addItem($leftBox);
        $flexbox->addItem($rightBox);


        return $flexbox;

    }

    private function btnSubMenu($ref)
    {
        $_a = new CTag('a',true);
        $icon_plus = xIcon($name="plus-circle-dotted", $type="bootstrap")->setClass("w-3 h-3");

        $create = (clone $_a)
            ->addItem( $icon_plus )
            ->setAttribute('wire:click',"$"."emit('popupFormCreate','".$ref."')");
        $create->addClass("btn-create");
        ////$create->additem($ref);
        return $create;
    }

}
