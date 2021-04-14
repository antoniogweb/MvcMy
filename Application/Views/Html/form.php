<?php
		
echo Html_Form::select('provincia','rovigo','optgroupOpen:veneto,rovigo,padova,optgroupOpen:toscana,firenze','ciao');

//select
$array = array('veneto'=>'veneto','rovigo'=>'rovigo');
echo Html_Form::select('provincia','rovigo',$array);

//input
echo Html_Form::input('mail','tonicucoz@gmail.com','bello');

//checkBox
echo Html_Form::checkbox('accetto',1,'1','class');

//hidden entry
echo Html_Form::hidden('id',1);

//password entry
echo Html_Form::password('password','dasads','pass');

//textarea
echo Html_Form::textarea('annuncio','ciao io mi chiamo antonio!!!','text');

//radio button
echo Html_Form::radio('azienda','legno','carta,legno','sdf','after');

//radio button with array
$array = array('carta' => 1, 'legno' => 2);
echo Html_Form::radio('aezienda',1,$array,'radioselect','before');