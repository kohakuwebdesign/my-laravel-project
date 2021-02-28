credentials(app ID, app Secret, scope) -> access token -> page ID -> instagram business account ID

1.get_access_token.php
2.get_pages.php <- これをした時点で long lived access_token(60日間有効)は無期限に変換される。同じaccess_tokenを使い続ければ良い
3.get_instagram_account.php