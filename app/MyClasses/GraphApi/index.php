<?php
namespace App\MyClasses\InstagramGraphApi\GraphApi;

include_once 'Configuration.php';
include_once 'AccessToken.php';
include_once 'FacebookPage.php';
include_once 'InstagramAccount.php';
include_once 'InstagramUserMetadata.php';
include_once 'InstagramHashtag.php';
include_once 'InstagramPostEmbed.php';
include_once 'GraphApiHelpter.php';

$access_token = new AccessToken();
$authorize = $access_token->authorize($_GET['code']);
$helper = new GraphApiHelpter();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Graph Api Normal access</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mt-5">appsecret_proofを使わない通常のアクセス方法</h1>
            <p>情報が取れない場合<br>
                ・フェイスブックデベロッパーページにて、マイアプリ>サイドバーの「設定」>「詳細設定」> 「App Secretをオンにする」をオンに設定。<br>
                ・Configuration.phpの「private $appsecret_proof_mode = true;」に設定<br>
                or<br>
                ・フェイスブックデベロッパーページにて、マイアプリ>サイドバーの「設定」>「詳細設定」> 「App Secretをオンにする」を<strong>オフ</strong>に設定。<br>
                ・Configuration.phpの「private $appsecret_proof_mode = false;」に設定<br>
                Configuration.phpの「private $facebook_redirect_uri」でリダイレクト先も好みに変更OK。
           </p>
            <?php if(isset($authorize['login_url'])) : ?>
                <a href="<?php echo $authorize['login_url']; ?>">Login with facebook</a>
            <?php else : ?>
                <div class="card mt-5">
                    <div class="card-header">
                        Facebookデベロッパーページでの設定「機能・アクセス」
                    </div>
                    <div class="card-body">
                        pages_show_list<br>
                        instagram_basic<br>
                        instagram_manage_insights<br>
                        public_profile
                    </div>
                </div>

                <h2 class="mt-5">Authorization</h2>
                <h3>response: </h3>
                <div class="card">
                <div class="card-body">
                <?php
                echo '<pre>';
                print_r($authorize);
                echo '</pre>';
                $long_term_accesstoken = $authorize['long_lived_accesstoken'];
                ?>
                </div>
                </div>


                <h2 class="mt-5">Facebook Page</h2>
                <div class="card">
                    <div class="card-header">
                        備考
                    </div>
                    <div class="card-body">
                        認証によって得られる「long_lived_accesstoken」の値をエンドポイントの「access_token」にわたす。<br>
                        認証で取得した「long_lived_accesstoken」をFacebookページを取得するエンドポイントへ渡すと期限なし（無期限）の「access_token」が返ってくる。<br>
                        今後はこの無期限の「access_token」を（念の為urlencode()して）使うことになる。<br>
                    </div>
                </div>
                <?php
                $facebook_page = new FacebookPage($authorize['long_lived_accesstoken']);
                echo '<h3 class="mt-3">Endpoint: </h3><p class="text-break">' . $facebook_page->getEndpoint() . '</p>';
                ?>
                <h3>response: </h3>
                <div class="card">
                <div class="card-body">
                <?php
                echo '<pre>';
                print_r($facebook_page->getFacebookPages());
                echo '</pre>';

                $infinit_term_access_token = $facebook_page->getFacebookPages()['data'][0]['access_token'];
                $facebook_page_id = $facebook_page->getFacebookPages()['data'][0]['id'];
                ?>
                </div>
                </div>


                <h2 class="mt-5">Instagram Business Account Id</h2>
                <?php
                $instagram_account = new InstagramAccount($infinit_term_access_token, $facebook_page_id);
                $instagram_business_account_id = $instagram_account->getResponse()['instagram_business_account']['id'];
                echo '<h3>Endpoint: </h3><p class="text-break">' . $instagram_account->getEndpoint() . '</p>';
                ?>
                <h3>response: </h3>
                <div class="card">
                <div class="card-body">
                <?php
                echo '<pre>';
                print_r($instagram_account->getResponse());
                echo '</pre>';
                ?>
                </div>
                </div>

                <h2 class="mt-5">Instagram User Meta Data</h2>
                <?php
                $instagram_user_metadata = new InstagramUserMetadata($infinit_term_access_token, $instagram_business_account_id);
                echo '<h3>Endpoint: </h3><p class="text-break">' . $instagram_user_metadata->getEndpoint() . '</p>';
                ?>
                <h3>response: </h3>
                <div class="card">
                <div class="card-body">
                <?php
                echo '<pre>';
                print_r($instagram_user_metadata->getResponse());
                echo '</pre>';
                ?>
                </div>
                </div>

                <h2 class="mt-5">Instagram Hashtag Id</h2>
                <div class="card">
                    <div class="card-header">
                        備考
                    </div>
                    <div class="card-body">
                        ここで使われる検索ワードが日本語の場合、urlencode()すると結果が思い通りに返ってこないのでurlencode()しない。
                    </div>
                </div>
                <?php
                $instagram_hashtag = new InstagramHashtag();
                $array = $instagram_hashtag->getHashTagId($long_term_accesstoken, $instagram_business_account_id, '迷い犬');
                echo '<h3>Endpoint: </h3><p class="text-break">' . $instagram_hashtag->getHashtagIdEndpoint() . '</p>';
                ?>
                <h3>response: </h3>
                <div class="card">
                    <div class="card-body">
                        <?php
                        var_dump($array);
                        $instagram_hashtag_id = $array['data'][0]['id'];
                        ?>
                    </div>
                </div>

                <h2 class="mt-5">Instagram Hashtag</h2>
                <?php
                $instagram_hashtag = new InstagramHashtag();
                $posts = $instagram_hashtag->getPostsDataFromHashtagId($instagram_hashtag_id, $instagram_business_account_id, $long_term_accesstoken);
                echo '<h3>Endpoint: </h3><p class="text-break">' . $instagram_hashtag->getPostDataEndpoint() . '</p>';
                ?>
                <h3>response: </h3>
                <div class="card">
                    <div class="card-body">
                        <?php
                        var_dump($posts);
                        ?>
                    </div>
                </div>

                <h2 class="mt-5">Instagram Embed</h2>
                <h3>response: </h3>
                <div class="card">
                    <div class="card-body">
                        <?php
                        foreach ($posts['data'] as $post){
                            $instagramPostEmbed = new InstagramPostEmbed($long_term_accesstoken, $post['permalink']);
                            echo '<h3>Endpoint: </h3><p class="text-break">' . $instagramPostEmbed->getEndpoint() . '</p>';
                            var_dump($instagramPostEmbed->getResponse());
                            echo $instagramPostEmbed->getResponse()['html'];
                            echo '<h3>Hashtag list</h3>';
                            var_dump($helper->getHashtagList($post['caption']));
                        }

                        ?>
                    </div>
                </div>


            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
