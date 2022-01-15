# Jiny site-Menu
사이트 메뉴 관리자 페키지는 지니 웹사이트를 운영관리에 필요한 메뉴 트리를 관리 합니다.

## 복수 메뉴 관리
메뉴 관리자는 메뉴항목들을 코드그룹으로 그룹화 하여 복수의 메뉴를 관리합니다.

메뉴 그룹은 관리자 페이지에서 등록할 수 있습니다.
* /admin/site/menu/code

## 메뉴항목 등록
메뉴 그룹페이지에서 `메뉴구조`를 클릭하면 세부 메뉴 항목을 설정할 수 있는 페이지로 이동됩니다.
새로운 항목을 추가하고, 추가된 항목들을 drag and drop 형태로 이동 배치를 쉽게 할 수 있습니다.

## 메뉴 적용하기
완성된 메뉴 트리를 사이트에 적용을 하기 위해서는 json 메뉴 설정 파일로 변환을 해주어야 합니다.
이는 임시 작업중인 메뉴들이 실제 사이트에 반영되지 안으면서, 쉽게 구조를 변경할 수 있는 장점이 있습니다.

`json 변환` 버튼을 클릭하세요.
### json 파일 관리하기
이렇게 변환된 파일들은 `/resources/menus` 폴더안에 저장이 됩니다. 저장된 파일들은 메뉴 파일 목록에서
확인이 가능합니다. 

### json 파일 업로드 하기
자신이 가지고 있는 메뉴 json 파일을 `/resources/menus` 폴더안에 올려두어 사용을 할 수도 있으며,
도는 메뉴 항목 생성기에서 업로드하여 json 설정값을 DB에 반영하여 편집할 수도 있습니다.



## UI 구성하기
이렇게 관리자 페이지에서 편집 생성된 json 메뉴 파일을 기반으로 사이트에 출력될 html 메뉴트리를 
출력할 수 있습니다.

### 블래이드 템플릿으로 출력하기
`x-menu-josn` 테그는 메뉴파일을 기반으로 HTML 코드를 생성한 결과를 반환 합니다.

```php
<x-menu-json path="menus/3.json">
</x-menu-json>
```

메뉴 설정파일은 `path` 태그를 이용하여 추가합니다. 이때 `/resources` 폴더안에 있는 `menus`경로명도
같이 적어 주셔야 합니다. `/menus`경로는 환경설정으로 변경될 수 있기 때문입니다.


### 메뉴 파일 경로생략
다음처럼 메뉴 path를 생략할 수 있습니다.
```php
<x-menu-json></x-menu-json>
```
이런경우 별도로 메뉴 경로를 응용프로그램에서 추가 설정을 해주어야 합니다.
이때에는 메뉴 헬퍼함수를 이용합니다.

```php
xMenu()->setPath('메뉴경로');
```

이는 `x-menu-json` 컴포넌트가 xMenu() 헬퍼를 통하여 메뉴를 생성하기 때문입니다.



## 심화학습
지니메뉴는 `/src/Menu.php` 클래스를 통하여 UI 메뉴를 생성합니다.
Menu 클래스는 싱글턴으로 제작되어 있으며, xMenu() 헬퍼함수를 통하여 호출할 수 있습니다.


