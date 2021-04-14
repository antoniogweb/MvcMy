<script type="text/javascript">

	$(document).ready(function() {

		$(".form_tab_a").click(function(){

			//togli la classe "corrente" a tutti gli elementi <li>
			$(".form_tab_li").removeClass("current_tab");

			//aggiungi la classe corrente all'elemento <li> padre dell'elemento cliccato
			$(this).parent().addClass("current_tab");

			//ottieni l'attributo "rel" dell'elemento cliccato
			var rel = $(this).attr("rel");

// 			alert(rel);
			//nascondi tutti i contenuti
			$(".tab_description_item").addClass("display_none");

			//mostra il contenuto corrispondente al tab cliccato
			$("#" + rel).removeClass("display_none");
			
			return false;
			
		});

	});

</script>

<?php echo $form;?>