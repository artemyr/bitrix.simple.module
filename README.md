# bitrix.simple.module

<p>Файлы модуля располагаются в папке <code>/bitrix/modules/<a href="http://dev.1c-bitrix.ru/api_help/main/general/identifiers.php" target="_blank">ID модуля</a>/</code>. Структура папки:</p>
<ul>
   <li>
      <code>admin/</code> - каталог с административными скриптами модуля;
      <ul>
         <li><b>menu.php</b> - файл с административным меню модуля;</li>
      </ul>
   </li>
   <li>
      <code>classes/</code> - скрипты с классами модуля;
      <ul>
         <li><code>general/</code> - классы модуля, не зависящие от используемой базы данных;</li>
         <li><code>mysql/</code> - классы модуля, предназначенные для работы только с MySQL;</li>
         <li><code>mssql/</code> - классы модуля, предназначенные для работы только с MS SQL;</li>
         <li><code>oracle/</code> - классы модуля, предназначенные для работы только с Oracle;</li>
      </ul>
   </li>
   <li><code>lang/ID языка/</code> - каталог с языковыми файлами скриптов модуля;</li>
   <li><code>lib/</code> - каталог с файлами (API: классы, логика) нового ядра D7 (может не присутствовать, если у модуля нет собственных методов);</li>
   <li>
      <code>install/</code> - каталог с файлами используемыми для инсталляции и деинсталляции модуля;
      <ul>
         <li><code>admin/</code> - каталог со скриптами подключающими административные скрипты модуля (<i>вызывающие скрипты</i>);</li>
         <li><code>js/</code> - каталог с js-скриптами модуля. Копируются в <code>/bitrix/js/ID_модуля/</code>;</li>
         <li>
            <code>db/</code> - каталог с SQL скриптами для инсталляции/деинсталляции базы данных;
            <ul>
               <li><code>mysql/</code> - SQL скрипты для инсталляции/деинсталляции таблиц в MySQL;</li>
               <li><code>mssql/</code> - SQL скрипты для инсталляции/деинсталляции таблиц в MS SQL;</li>
               <li><code>oracle/</code> - SQL скрипты для инсталляции/деинсталляции таблиц в Oracle;</li>
            </ul>
         </li>
         <li><code>images/</code> - каталог с изображениями используемыми модулем; после инсталляции модуля они должны быть скопированы в каталог <code>/bitrix/images/ID модуля/</code>;</li>
         <li>
            <code>templates/</code> - каталог с компонентами 1.0 модуля. (Каталог сохраняется только с целью совместимости версий.);
            <ul>
               <li><code>ID модуля/</code> - каталог с основными файлами компонент;</li>
               <li><code>lang/ID языка/ID модуля/</code> - в данном каталоге находятся языковые файлы компонент модуля;</li>
            </ul>
         </li>
         <li><code>components/пространство имен/имя компонента/</code> - каталог с компонентами 2.0 модуля;</li>
         <li><code>themes/имя_модуля/</code> - содержит <b>css</b> и картинки для стилей административной панели, если модуль в таковых нуждается (Устаревшая, до версии 12.0);</li>
         <li><code>panel/имя_модуля/</code> - содержит <b>css</b> и картинки для стилей административной панели, если модуль в таковых нуждается.</li>
         <li><b>index.php</b> - файл с описанием модуля;</li>
         <li><b>version.php</b> - файл с номером версии модуля. Версия не может быть равной нулю.</li>
      </ul>
   </li>
   <li><b>include.php</b> - данный файл подключается в тот момент, когда речь идет о подключении модуля в коде, в нем должны находиться включения всех файлов с библиотеками функций и классов модуля;</li>
   <li>
      <b>default_option.php</b> - содержит массив с именем <code>$ID модуля_default_option</code>, в котором заданы значения по умолчанию для параметров модуля;
      <p></p>
      <div class="hint"><b>Примечание</b>: В случае партнерских модулей, в названии которых содержится точка (пример - <b>mycompany.forum</b>) в имени переменной точка будет автоматически заменена на символ подчеркивания.</div>
      <p></p>
   </li>
   <li><b>options.php</b> - данный файл подключается на странице настройки параметров модулей в административном меню <b>Настройки</b>;</li>
   <li><b>prolog.php</b> - файл может подключаться во всех административных скриптах модуля. Обычно в нем определяется константа <code>ADMIN_MODULE_NAME</code> (идентификатор модуля), используемая в панели управления;</li>
   <li><b>.settings.php</b> - файл настроек модуля, описывающий настройки модуля, которые можно прочитать через <code>\Bitrix\Main\Config\Configuration::getInstance($module)</code>.</li>
</ul>
