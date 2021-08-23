<? AddEventHandler('sale', 'OnOrderNewSendEmail', 'OnOrderNewSendEmailHandler');
function OnOrderNewSendEmailHandler($ID, &$eventName, &$arFields)
    {
        if ($ID > 0 && CModule::IncludeModule('iblock')) {
            $arFields['ORDER_TABLE_ITEMS'] = '<table cellpadding="5" cellspacing="5">';
            $rsBasket = CSaleBasket::GetList(array(), array('ORDER_ID' => $ID));
            $rsOrder = CSaleOrder::GetList(array(), array('ID' => $ID));
            $acc_number = $rsOrder->Fetch()['ACCOUNT_NUMBER'];
            $acc = explode("/", $acc_number);
            $order_url = 'https://' . $GLOBALS['SERVER_NAME'] . '/personal/orders/' . $acc[0] . '%252F' . $acc[1];
            while ($arBasket = $rsBasket->GetNext()) {
                $arPicture = false;
                if ($arBasket['MODULE'] == 'catalog') {
                    $mxResult = CCatalogSku::GetProductInfo($arBasket['PRODUCT_ID']);
                    if (is_array($mxResult) && !empty($mxResult['ID'])) {
                        $arProduct = CIBlockElement::GetByID($mxResult['ID'])->Fetch();
                        $prop_common = CIBlockElement::GetByID($mxResult['ID']);
                    } else {
                        $arProduct = CIBlockElement::GetByID($arBasket['PRODUCT_ID'])->Fetch();
                        $prop_common = CIBlockElement::GetByID($arBasket['PRODUCT_ID']);
                    }
                    $ob = $prop_common->GetNextElement();
                    $prop = $ob->GetProperties();
                    $b = $prop['MINIMAL_COUNT_GOODS']['VALUE'];
                    $measure = ($prop['WEIGHTED_GOODS']['~VALUE']) ? 'гр.' : 'шт.';
                    if ($arProduct) {
                        if ($arProduct['PREVIEW_PICTURE'] > 0) {
                            $fileID = $arProduct['PREVIEW_PICTURE'];
                        } elseif ($arProduct['DETAIL_PICTURE'] > 0) {
                            $fileID = $arProduct['DETAIL_PICTURE'];
                        } else {
                            $fileID = 0;
                        }
                        $arPicture = CFile::ResizeImageGet($fileID, array('width' => 90, 'height' => 110));
                        $arPicture['SIZE'] = getimagesize($_SERVER['DOCUMENT_ROOT'] . $arPicture['src']);
                    }
                }
                $summ = $arBasket['PRICE'] * (int)$arBasket['QUANTITY'];
                $arFields['ORDER_TABLE_ITEMS'] .= '<tr valign="top">'
                    . '<td>' . ($arPicture ? '<img src="https://' . $GLOBALS['SERVER_NAME'] . (str_replace(array('+', ' '), '%20', $arPicture['src']))
                        . '" width="' . $arPicture['SIZE'][0] . '" height="' . $arPicture['SIZE'][1] . '" alt="">' : '') . '</td>'
                    . '<td><p style="max-width: 350px; width: 100%; padding-left: 20px">' . $arBasket['NAME'] . '</p><span style="color: #7c7c7c; display: block; padding-left: 20px">'. $arBasket['QUANTITY'] . ' ' .$measure. '</span></td>'
//                    . '<td style="white-space: nowrap">' . $arBasket['QUANTITY'] . ' ' .$measure.'</td>'
                    . '<td><p style="font-weight: bold; padding-left: 80px">' . SaleFormatCurrency($summ,
                        $arBasket['CURRENCY']) . '</p></td>'
                    . '</tr>';
            }

            $arFields['ORDER_TABLE_ITEMS'] .= '</table>';
            $arFields['ORDER_NEW_ID'] = '    <a class="question" style="text-decoration: none; margin-top: 20px; margin-bottom: 5px; margin-left: -5px; padding: 10px 30px; font-size: 14px; border-radius: 3px; font-weight: 600; display: inline-block; background-color: #964b00; color: #ffffff" href = "' . $order_url . '">Перейти к заказу</a>
';
        }
    }
?>
