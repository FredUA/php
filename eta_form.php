<?php

if ( isset( $_POST['submit-foo'] ) )
{
  $a_data = $a_error = [ ];

  //1
  $a_data['text_field'] = ( isset( $_POST['text_field'] ) and is_string( $_POST['text_field'] ) )
    ? trim( $_POST['text_field'] ) : '';

  $a_data['password_field'] = ( isset( $_POST['password_field'] ) and is_string( $_POST['password_field'] ) )
    ? trim($_POST['password_field']) : '';

  $a_data['checkbox_field'] = ( isset( $_POST['checkbox_field'] ) ) ? 1 : 0;

  $a_data['radio_field'] = ( isset( $_POST['radio_field'] ) and is_string( $_POST['radio_field'] ) )
    ? $_POST['radio_field'] : '';

  $a_data['hidden_field'] = ( isset( $_POST['hidden_field'] ) and is_string( $_POST['hidden_field'] ) )
    ? trim($_POST['hidden_field']) : '';

  $a_data['select'] = ( isset( $_POST['select'] ) and is_string( $_POST['select'] ) )
    ?$_POST['select'] : '';

  $a_data['selectm'] = ( isset( $_POST['selectm'] ) and is_array( $_POST['selectm'] ) )
    ? $_POST['selectm'] : [];

  $a_data['textarea'] = ( isset( $_POST['textarea'] ) and is_string( $_POST['textarea'] ) )
    ? trim($_POST['textarea']) : '';
  
  echo '<pre>';
  print_r ( $a_data );
  echo '</pre>';
  echo '<pre>';
  print_r ( $_POST );
  echo '</pre>';
  //2
  if ( '' == $a_data['text_field'] )
    $a_error['text_field'] = 'Дані не введено';

  else if ( in_array( $a_data['text_field'], ['foo', 'bar'] ) )
    $a_error['text_field'] = 'Строка складається з недопусмих слів';

  else if ( mb_strlen( $a_data['text_field'] ) > 10 )
    $a_error['text_field'] = 'Строка перевищуэ 10 символів';

  
  if ( empty( $a_data['password_field'] ) )
    $a_error['password_field'] = 'Дані не введено';

  else if ( is_numeric( $a_data['password_field'] ) )
    $a_error['password_field'] = 'Пароль не може бути числом';

  else if ( mb_strlen( $a_data['password_field'] ) < 5 )
    $a_error['password_field'] = 'Пароль має бути більше 5 символів';

  
  if ( 0 === $a_data['checkbox_field'] )
    $a_error['checkbox_field'] = 'Чекбокс потрібно вибрати';

  
  if ( ! in_array( $a_data['radio_field'], [ 1, 2 ] ) )
    $a_error['radio_field'] = 'Виберіть значення зі списку';

  
  if ( ! in_array( $a_data['select'], [ 'v1', 'v2', 'v3' ] ) )
    $a_error['select'] = 'Виберіть значення зі списку';

  if ( empty( $a_data['selectm'] ) )
    $a_error['selectm'] = 'Виберіть значення зі списку або переданий варіант не знайдено';
  else
  {
    foreach ( $a_data['selectm'] as $row )
    {
      if ( is_array( $row ) )
        $a_error['selectm'] = 'Передан многомерный массив. Ошибка передачи данных' ;
      
      else if ( ! in_array( (string)$row, [ 'v11', 'v12', 'v13' ] ) )
        $a_error['selectm'] = 'Один из переданных отмеченных вариантов списка не найден в нем' ;
    }
  }
  
  if ( '' == $a_data['textarea'] )
    $a_error['textarea'] = 'Дані не введено';

  else if ( mb_strlen( $a_data['textarea'] ) > 100 )
    $a_error['textarea'] = 'Строка перевищуэ 100 символів';

  //3
  if ( ! isset( $a_error['text_field'] ) )
  {
    //додаткова перевірка
    /**
     * SQL
     *
     * if ( exists )
     *   $a_error['text_field'] = 'text error';
     */
  }

  //4
  if ( ! $a_error )
  {
    echo 'Виконуємо дію';
    echo '<pre>';
    print_r( $a_data );
    echo '</pre>';
  }
  else
  {
    echo '<h1>В даних знайдено помилки:</h1>';

//    foreach ( $a_error as $key => $error )
//      echo "В полі {$key} знайдено помилку: {$error}<br />";
  }
}
?>
<form action="" method="post">
  <input required="required" maxlength="10" type="text" name="text_field"
         value="<?= ( isset( $a_data['text_field'] ) ? htmlspecialchars( $a_data['text_field'] ) : '' ) ?>" /><br />
  <?= ( ( isset( $a_error['text_field'] ) ) ? '<span style="color: red">' . $a_error['text_field'] . '</span><br />' : '' ) ?>

  <input type="password" name="password_field" /><br />
  <?= ( ( isset( $a_error['password_field'] ) ) ? '<span style="color: red">' . $a_error['password_field'] . '</span><br />' : '' ) ?>

  <input type="checkbox" name="checkbox_field" value="123"<?= ( ( isset( $a_data['checkbox_field'] ) and $a_data['checkbox_field'] == 1 ) ? ' checked="checked"' : '' ) ?>/><br />
  <?= ( ( isset( $a_error['checkbox_field'] ) ) ? '<span style="color: red">' . $a_error['checkbox_field'] . '</span><br />' : '' ) ?>

  <input type="radio" name="radio_field" value="1" <?= ( ( isset( $a_data['radio_field'] ) and $a_data['radio_field'] == 1 ) ? ' checked="checked"' : '' ) ?>/><br />
  <input type="radio" name="radio_field" value="2" <?= ( ( isset( $a_data['radio_field'] ) and $a_data['radio_field'] == 2 ) ? ' checked="checked"' : '' ) ?>/><br />
  <?= ( ( isset( $a_error['radio_field'] ) ) ? '<span style="color: red">' . $a_error['radio_field'] . '</span><br />' : '' ) ?>

  <input type="hidden" name="hidden_field" value="yes,sir" /><br />

  <select name="select">
    <option></option>
    <option value="v1"<?= ( ( isset( $a_data['select'] ) and $a_data['select'] == 'v1' ) ? ' selected="selected"' : '' ) ?>>v1</option>
    <option value="v2"<?= ( ( isset( $a_data['select'] ) and $a_data['select'] == 'v2' ) ? ' selected="selected"' : '' ) ?>>v2</option>
    <option value="v3"<?= ( ( isset( $a_data['select'] ) and $a_data['select'] == 'v3' ) ? ' selected="selected"' : '' ) ?>>v3</option>
  </select><br />
  <?= ( ( isset( $a_error['select'] ) ) ? '<span style="color: red">' . $a_error['select'] . '</span><br />' : '' ) ?>

  <select name="selectm[]" multiple="multiple">
    <option value="v11"<?= ( ( isset( $a_data['selectm'] ) and in_array( 'v11', $a_data['selectm'] ) ) ? ' selected="selected"' : '' ) ?>>v11</option>
    <option value="v12"<?= ( ( isset( $a_data['selectm'] ) and in_array( 'v12', $a_data['selectm'] ) ) ? ' selected="selected"' : '' ) ?>>v12</option>
    <option value="v13"<?= ( ( isset( $a_data['selectm'] ) and in_array( 'v13', $a_data['selectm'] ) ) ? ' selected="selected"' : '' ) ?>>v13</option>
  </select><br />
  <?= ( ( isset( $a_error['selectm'] ) ) ? '<span style="color: red">' . $a_error['selectm'] . '</span><br />' : '' ) ?>

  <textarea name="textarea"><?= ( isset( $a_data['textarea'] ) ? $a_data['textarea'] : '' ) ?></textarea><br />
  <?= ( ( isset( $a_error['textarea'] ) ) ? '<span style="color: red">' . $a_error['textarea'] . '</span><br />' : '' ) ?>

  <input type="submit" name="submit-foo" value="SEND" />
</form>


