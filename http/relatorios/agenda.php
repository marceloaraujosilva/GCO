﻿<?php
   /**
    * Gerenciador Clínico Odontológico
    * Copyright (C) 2006 - 2009
    * Autores: Ivis Silva Andrade - Engenharia e Design(ivis@expandweb.com)
    *          Pedro Henrique Braga Moreira - Engenharia e Programação(ikkinet@gmail.com)
    *
    * Este arquivo é parte do programa Gerenciador Clínico Odontológico
    *
    * Gerenciador Clínico Odontológico é um software livre; você pode
    * redistribuí-lo e/ou modificá-lo dentro dos termos da Licença
    * Pública Geral GNU como publicada pela Fundação do Software Livre
    * (FSF); na versão 2 da Licença invariavelmente.
    *
    * Este programa é distribuído na esperança que possa ser útil,
    * mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÂO
    * a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
    * Licença Pública Geral GNU para maiores detalhes.
    *
    * Você recebeu uma cópia da Licença Pública Geral GNU,
    * que está localizada na raíz do programa no arquivo COPYING ou COPYING.TXT
    * junto com este programa. Se não, visite o endereço para maiores informações:
    * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html (Inglês)
    * http://www.magnux.org/doc/GPL-pt_BR.txt (Português - Brasil)
    *
    * Em caso de dúvidas quanto ao software ou quanto à licença, visite o
    * endereço eletrônico ou envie-nos um e-mail:
    *
    * http://www.smileodonto.com.br/gco
    * smile@smileodonto.com.br
    *
    * Ou envie sua carta para o endereço:
    *
    * Smile Odontolóogia
    * Rua Laudemira Maria de Jesus, 51 - Lourdes
    * Arcos - MG - CEP 35588-000
    *
    *
    */
	include "../lib/config.inc.php";
	include "../lib/func.inc.php";
	include "../lib/classes.inc.php";
	require_once '../lang/'.$idioma.'.php';
	header("Content-type: text/html; charset=ISO-8859-1", true);
	if(!checklog()) {
		die($frase_log);
	}
	include "../timbre_head.php";
	$sql = "SELECT nome FROM pacientes WHERE codigo = ".$_GET['codigo'];
	$query = mysql_query($sql) or die('Line 40: '.mysql_error());
	$row = mysql_fetch_array($query);
?>
<font size="3"><?php echo $LANG['reports']['scheduled_consultations_of']?> <b><?php echo $row['nome']?> [<?php echo $_GET['codigo']?>]</b></font><br /><br />
<table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <th width="15%" align="left"><?php echo $LANG['reports']['date']?>
    </th>
    <th width="15%" align="left"><?php echo $LANG['reports']['time']?>
    </th>
    <th width="25%" align="left"><?php echo $LANG['reports']['procedure']?>
    </th>
    <th width="30%" align="left"><?php echo $LANG['reports']['professional']?>
    </th>
    <th width="15%" align="left"><?php echo $LANG['reports']['missed']?>
    </th>
  </tr>
<?php
    $i = 0;
    $sql = "SELECT * FROM v_agenda WHERE codigo_paciente = ".$_GET['codigo']." ORDER BY data ASC";
    $query = mysql_query($sql) or die('Line 60: '.mysql_error());
    while($row = mysql_fetch_array($query)) {
        if($i % 2 === 0) {
            $td_class = 'td_even';
        } else {
            $td_class = 'td_odd';
        }
?>
  <tr class="<?php echo $td_class?>" style="font-size: 12px">
    <td><?php echo converte_data($row['data'], 2)?>
    </td>
    <td><?php echo substr($row['hora'], 0, 5)?>
    </td>
    <td><?php echo $row['procedimento']?>
    </td>
    <td><?php echo (($row['sexo_dentista'] == 'Masculino')?'Dr.':'Dra.').' '.$row['nome_dentista']?>
    </td>
    <td><?php echo (($row['faltou'] == 'Sim')?'Sim':'')?>
    </td>
  </tr>
<?php
        $i++;
    }
?>
</table>
<script>
window.print();
</script>
<?php
    include "../timbre_foot.php";
?>