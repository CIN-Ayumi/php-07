<?php
// デバック練習問題
// コードを読みデバックしつつジャンケンゲームを完成させてください。
// 判定が勝った時のみ勝利回数を表示させてください。
// 例)
// 山田太郎はグーを出しました。
// 相手はチョキを出しました。
// 勝敗は勝ちです。
// 3回目の勝利です。
// $_SESSIONの挙動やswitch文については調べてみてください。

//sessionを使用するときは必ず先頭につける
session_start();

//$_session['result']に値が入っていない時、0を代入
if (! isset($_SESSION['result'])) {
    $_SESSION['result'] = 0;
}

class Player
{    
    public function jankenConverter(int $choice): string
    {
        $janken = '';
        switch ($choice) {
            case 1:
                $janken = 'グー';
                break;
            case 2:
                $janken = 'チョキ';
                break; //caseごとにbreakが必要
            case 3:
                $janken = 'パー';
                break;
            default:
                break;
        }
        return $janken;
    }
}

class Me
{
    private $name;
    private $choice;

    public function __construct(string $lastName, string $firstName, int $choice)
    {
        $this->name   = $lastName.$firstName;
        $this->choice = $choice;
        $choice = $_REQUEST['choice']; //セレクトボックスの値を$choiceに代入
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getChoice(): string
    {
        $player = new Player();  //クラスを使用するためにインスタンスを作成
        return $player->jankenConverter($this->choice);
    }

}

class Enemy
{
    private $choice;

    public function __construct()
    {
        $this->choice = random_int(1, 3); //random_int() 1~3の中でランダムな整数を返す
    }
    public function getChoice(): string
    {
        $enemy = new Player(); //インスタンス作成
        return $enemy->jankenConverter($this->choice); //ここでのthis choiceはランダムな整数
    }
}

class Battle
{
    private $first;
    private $second;
    public function __construct(Me $me, Enemy $enemy)
    {
        $this->first  = $me->getChoice();
        $this->second = $enemy->getChoice();
        $this->countVictories(); //勝ったら1足す
    }

    private function judge(): string //int -> string 文字列を返したいので
    {
        if ($this->first === $this->second) {
            return '引き分け';
        }

        if ($this->first === 'グー' && $this->second === 'チョキ') {
            return '勝ち';
        }

        if ($this->first === 'グー' && $this->second === 'パー') {
            return '負け';
        }

        if ($this->first === 'チョキ' && $this->second === 'グー') {
            return '負け';
        }

        if ($this->first === 'チョキ' && $this->second === 'パー') {
            return '勝ち';
        }

        if ($this->first === 'パー' && $this->second === 'グー') {
            return '勝ち';
        }

        if ($this->first === 'パー' && $this->second === 'チョキ') {
            return '負け';
        }
    }

    private function countVictories()
    {
        if ($this->judge() === '勝ち') {
           $_SESSION['result'] += 1;
        }
    }

    public function getVitories()
    {
        return $_SESSION['result'];
    }

    public function showResult()
    {
        return $this->judge();
    }
}

if (! empty($_POST)) {
    $me    = new Me($_POST['last_name'], $_POST['first_name'], $_POST['choice']);
    $enemy = new Enemy();
    echo $me->getName().'は'.$me->getChoice().'を出しました。';
    echo '<br>';
    echo '相手は'.$enemy->getChoice().'を出しました。';
    echo '<br>';
    $battle = new Battle($me, $enemy);
    echo '勝敗は'.$battle->showResult().'です。';
    if ($battle->showResult() === '勝ち') {

        echo '<br>';
        echo $battle->getVitories().'回目の勝利です。';
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>デバック練習</title>
</head>
<body>
    <section>
    <form method="post" action='./lesson3.php'>
        <label>姓</label>
        <input type="text" name="last_name" value="<?php echo '山田' ?>" />
        <label>名</label>
        <input type="text" name="first_name" value="<?php echo '太郎' ?>" />
        <select name='choice'>
            <option value=0 >--</option>
            <option value=1 >グー</option>
            <option value=2 >チョキ</option>
            <option value=3 >パー</option>
        </select>
        <input type="submit" value="送信する"/>
    </form>
    </section>
</body>
</html>
