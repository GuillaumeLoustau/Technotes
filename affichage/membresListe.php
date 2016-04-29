<h2>Membres</h2>
<?PHP
if ($_SESSION['membreConsulter'] == 1)
{
	?>
		<table width="100%" cellpadding="2" border="0">
			<?php
			$membreGestion = new MembreGestion($BDD);
			$listeMembres = $membreGestion->getList();
			foreach ($listeMembres as $idMembre=>$membre )
			{
				?>
				<tr>
					<td valign="top"><a href="index.php?action=membreFormulaire&id_membre=<?PHP echo $idMembre;?>"><?PHP echo $membre->getPseudo(); ?></a></td>
				</tr>
				<?PHP
			}
			?>
		</table>
	<?PHP
}
?>