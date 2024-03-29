<?php
/*
 * jinyPHP
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jiny\Menu;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;

class JinyMenuServiceProvider extends ServiceProvider
{
    private $package = "jinymenu";
    public function boot()
    {
        // 모듈: 라우트 설정
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->package);

        // 데이터베이스
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        //Blade::component(\Jiny\Admin\View\Components\Tree::class, "admin-tree");

        //메뉴 빌더를 호출
        Blade::component(\Jiny\Menu\View\Components\Menu::class, "menu-json");

        // 마우스 오른쪽 클릭메뉴
        // context
        Blade::component(\Jiny\Menu\View\Components\Context::class, "context-menu");
    }

    public function register()
    {
        /* 라이브와이어 컴포넌트 등록 */
        $this->app->afterResolving(BladeCompiler::class, function () {
            //Livewire::component('LiveTreeJson', \Jiny\Admin\Http\Livewire\LiveTreeJson::class);



            ## Livewire::component('WireTree', \Jiny\Menu\Http\Livewire\Admin\WireTree::class);
            Livewire::component('WireTreeDrag', \Jiny\Menu\Http\Livewire\Admin\WireTreeDrag::class);

            // PopupForm을 상속 재구현한 tree 입력폼 처리루틴
            Livewire::component('PopupTreeFrom', \Jiny\Menu\Http\Livewire\Admin\PopupTreeFrom::class);

            Livewire::component('WireUpload', \Jiny\Menu\Http\Livewire\Admin\WireUpload::class);
            //Livewire::component('Admin-SiteMenu-Code', \Jiny\Menu\Http\Livewire\Admin\MenuCodeWire::class);


            Livewire::component('menu-json', \Jiny\Menu\Http\Livewire\Menu::class);



        });

    }

}
