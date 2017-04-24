# Menu System Library
PHP library load, manage, display and validate menus and navigations.

It is a component I often use in my own web projects to maintain a menu representation stored at one location.<br>
The system is stored in one or more XML files that represent a menu with items, submenus and sidemenus.

## Create Menus
You can create menus using the classes TASoft\MenuSystem\Menu and TASoft\MenuSystem\MenuItem.<br>
The menu and menu-items have a built-in consistency manager that guarantees correct dependencies.<br>
For example:
````php
$menu = new TASoft\MenuSystem\Menu('Menu Name');
$menuItem = new TASoft\MenuSystem\MenuItem('Item');

$menu->addItem($menuItem);
// Adds the menu item to the menu and sets the menu-item's parent menu to $menu.
// Test:
if($menu == $menuItem->getMenu())
  echo "Worked fine.";
else
  echo "Did not work"; // Should never appear.
````
Removing a menu-item also removes the reference to the parent menu.

### Creating from XML
MenuSystem ships with a factory set to create menus and menu-items.<br>
An implemented factory is TASoft\MenuSystem\Menu\Factory\MenuFromXML.<br>
It reads an XML file (which must follow the menu.dtd document type) and<br>
creates according to it the menu with all dependent menus and menu-items.
````php
use TASoft\MenuSystem as MS;
$f = new MS\Menu\Factory\MenuFromXML('path/to/menu.xml');
$menu = $f->getMenu();
// And that's all
````
To setup menus with factories there are 4 hooks to control the loading:
1. Poilcy: Determines wether a menu item is enabled and/or visible.
2. Selector: Determines wether a menu item is selected or not.
3. Target Generator: Creates dynamically targets for menu-items.
4. Translator: The title can be localized
