$table->string('name');
$table->string('address')->nullable();
$table->string('city')->nullable();
$table->string('type')->nullable();
$table->string('color_code')->nullable();

'id,name,address'
'name,address,city,type,color_code'


// if ($data['id']) {}
// dd($data, $data->getOriginal());

// print_r($arr);
/*
foreach ($arr as $key => $value) {
$found_key = array_search($key, array_column($this->fields, 'entityname'));
// var_dump("<br>found_key", $found_key, " : key -> ", $key);

if ($found_key != false) {
var_dump($found_key . ' -> ' . $this->fields[$found_key]->value);
$this->fields[$found_key]->value = $value; //"CPA-613-369-762"; // $value;
var_dump($this->fields[$found_key]->value);
}
}*/

// $this->fields[0]->value = "Hello";
// $this->fields[false]->value = "Hello False";

// print_r($this->fields);
// die();