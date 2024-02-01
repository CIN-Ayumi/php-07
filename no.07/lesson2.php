<?php

// デバック練習
// 氏名入力時に入力内容が表示されるようにプログラムを完成させてください。

$createAgeGroup = function () {
    $maxAge = 70;
    $minAge = 18;
    $ageGroup = array();
    for ($i = $minAge; $i <= $maxAge; $i++) {
        array_push($ageGroup, $i);
    }
    return $ageGroup;
};

class SelfIntroduction
{
    private $lastName;
    private $firstName;
    private $age;
    private $hobby;

    public function __construct(
        string $lastName,
        string $firstName,
        int $age,
        string $hobby
    ) {
        $this->lastName     = $lastName;
        $this->firstName    = $firstName;
        $this->age          = $age;
        $this->hobby        = $hobby;
    }

    public function getFullName()
    {
        return $this->lastName.$this->firstName;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getHobby()
    {
        return $this->hobby;
    }
}

if (! empty($_POST)) {
    $lastName         = $_POST['last_name'];
    $firstName        = $_POST['first_name'];
    $age              = $_POST['age'];
    $hobby            = $_POST['hobby'];

    $selfIntroduction = new SelfIntroduction ($lastName, $firstName, $age, $hobby);

    if ($selfIntroduction) {
        echo '私の名前は'.$selfIntroduction->getFullName().'年齢は'.$selfIntroduction->getAge().'です。';
        echo '<br>';
        echo '趣味は'. $selfIntroduction->getHobby().'です。';
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
    <form action='./lesson2.php' method="post">
        <label>姓</label>
        <input type="text" name="last_name"/>
        <label>名</label>
        <input type="text" name="first_name" />
        <label>趣味</label>
        <input type="text" name="hobby" />
        <select name="age">
            <?php foreach ($createAgeGroup() as $age) :?>
                <option value="<?php echo $age ?>" ><?php echo $age ?> </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="送信する"/>
    </form>
    </section>
</body>
</html>

