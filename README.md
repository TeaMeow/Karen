<p align="center">
  <img src="http://imgur.com/n7sefeK.png"/>
</p>
<p align="center">
  <i>Hey! Ohayō gojaimasu!</i>
</p>

&nbsp;

# Karen

可憐（カレン）是一個基於 PHP 的多國語言套件，主要以儲存為語言檔案為主並且支援評分系統，

你可以將可憐用於小型網站或者是大規模網站，使用可憐之前，需要知道的是 ISO 639 和 ISO 3166。

&nbsp;

# 特色

1. 以關鍵字為索引

2. 簡潔的使用方式

3. 支援複數和單數

4. 自動客戶端語言偵測

5. 支援評分優先（可選）

6. 將語系儲存為檔案

7. 線上免安裝編輯界面

&nbsp;

# 索引

1. 範例

2. 起始設定

  * 目錄結構
  
  * 簡寫
  
  * 語系位置
  
  * 預設語系

3. 九条 カレン

&nbsp;

# 範例

```php
/** 首先設定語系位置，和預設語言 */
$karen = new Karen('language/', 'zh_TW');

/** 現在可以開始輸出語言啦！ */
_e('hello_world');
```

&nbsp;

# 起始設定

你必須先初始化可憐，才可以進行多國語言的工作。

&nbsp;

## 目錄結構

你需要至少一個主資料夾，用來擺放語系檔案，並且必須按照這個結構。



&nbsp;

## 簡寫

你可以在一開始 new 這個類別的時候就先設定好語系位置和預設語系的選項。

```php
new Karen('語系位置', '預設語系')

/** 像這樣 */
new Karen('languages/', 'zh_TW')
```

&nbsp;

## 語系位置

&nbsp;

## 預設語系

&nbsp;

# 九条 カレン

![What?](http://imgur.com/cvvTFKE.png)
