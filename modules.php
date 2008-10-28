<?
$page["url"] = $_GET["page"];

$page["access"] = 0;

switch($page["url"])
{
	case "account.register";
		$page["subTitle"] = "Criação de nova Conta";
		$module = "modules/account/register.php";
	break;

	case "account.main";
		$module = "modules/account/main.php";
		$needLogin = true;
	break;	
	
	case "account.login";
		$module = "modules/account/login.php";
	break;		
	
	case "account.premium";
		$module = "modules/account/premium.php";
	break;	

	case "account.commands";
		$module = "modules/account/showCommands.php";
	break;		
	
	case "account.changePassword";
		$module = "modules/account/change.password.php";
	break;	

	case "account.changeEmail";
		$module = "modules/account/change.email.php";
	break;		

	case "account.changeInformations";
		$module = "modules/account/change.informations.php";
	break;		
	
	case "account.cancelChangeEmail";
		$module = "modules/account/change.emailCancel.php";
	break;			
	
	case "account.getPremiumTest";
		$module = "modules/account/testPremium.php";
	break;		
	
	case "account.setSecretQuestion";	
		$module = "modules/account/set.secretQuestion.php";
		$page["subTitle"] = "Perguntas e Respostas Secretas";
	break;		
	
	case "lostInterface";
		$module = "modules/lostInterface/main.php";
		$page["subTitle"] = "Interface de Recuperação de Contas";
	break;		
	
	case "account.getTickets";
		$needLogin = true;
		$module = "modules/account/getTickets.php";
	break;		
	
	case "account.viewTickets";
		$needLogin = true;
		$module = "modules/account/viewTickets.php";
	break;			

	//MODULO PERSONAGENS
	
	case "character.create";
		$needLogin = true;
		$module = "modules/characters/create.php";
		$page["subTitle"] = "Criar novo Personagem";
	break;		
	
	case "character.details";
		$module = "modules/characters/details.php";
	break;			
	
	case "character.delete";
		$module = "modules/characters/delete.php";
	break;		
	
	case "character.cancelDeletion";
		$module = "modules/characters/cancelDeletion.php";
	break;		
	
	case "character.changeSex";
		$module = "modules/characters/change.sex.php";
	break;	

	case "character.changeName";
		$module = "modules/characters/change.name.php";
	break;		
	
	case "character.getBeneficts";
		$module = "modules/characters/shop.beneficts.php";
	break;		
	
	case "character.itemShop";
		$module = "modules/characters/shop.items.php";
	break;	

	case "character.getTutor";
		$module = "modules/characters/shop.tutor.php";
	break;	

	case "character.edit";
		$module = "modules/characters/edit.php";
	break;			
	
	//MODULO SCREENSHOTS
	
	case "screenshot.post";
		$module = "modules/screenshots/post.php";
	break;	

	case "screenshot.vote";
		$module = "modules/screenshots/vote.php";
	break;			

	//MODULO CONTRIBUIÇÕES

	case "contribute.make";
		$module = "modules/contribution/make.php";
	break;			
	
	case "contribute.informations";
		$module = "modules/contribution/priceList.php";
	break;	
	
	case "contribute.beneficts";
		$module = "modules/contribution/beneficts.php";
	break;		
	
	//MODULO COMUNIDADE
	
	case "community.highscores";
		$module = "modules/community/highscores.php";
	break;	

	case "community.guilds";
		$module = "modules/community/guilds.php";
	break;		
	
	case "community.guildDetails";
		$module = "modules/community/guildDetails.php";
	break;		
	
	case "community.houses";
		$module = "modules/community/houses.php";
	break;		
	
	case "community.polls";
		$module = "modules/community/polls.php";
	break;			
	
	case "community.voteInPoll";
		$module = "modules/community/poll.vote.php";
	break;		
	
	case "community.lastKills";
		$module = "modules/community/lastKills.php";
	break;	

	case "community.whoIsOnline";
		$module = "modules/community/whoisonline.php";
	break;		
	
	//MODULO NOTICIAS
	
	case "news.files";
		$module = "modules/news/files.php";
	break;
	
	case "news.last";
		$module = "modules/news/last.php";
	break;	

	//OUTROS MODULOS	
	
	case "about";
		$module = "modules/others/about.php";
	break;		
	
	case "faq";
		$module = "modules/others/faq.php";
	break;		
	
	case "downloads";
		$module = "modules/others/downloads.php";
	break;	

	case "support";
		$module = "modules/others/support.php";
	break;			
	
	//MODULOS DARGHOPEDIA	
	
	case "darghopedia";
		$module = "modules/darghopedia/index.php";
	break;			
	
	case "darghopedia.npcs";
		$module = "modules/darghopedia/npcs.php";
	break;	

	//MODULOS ADMINISTRAÇÂO

	case "admin.newsManager";
		$module = "modules/admin/newsManager.php";
	break;		
	
	case "admin.tickerManager";
		$module = "modules/admin/newsTickerManager.php";
	break;		
	
	case "admin.editText";
		$module = "modules/admin/editTexts.php";
	break;		
	
	case "admin.newPoll";
		$module = "modules/admin/newPoll.php";
	break;		
	
	case "admin.premiumAdd";
		$module = "modules/admin/premium.add.php";
	break;		
	
	case "admin.premiumView";
		$module = "modules/admin/premium.view.php";
	break;	

	case "admin.premiumPayments";
		$module = "modules/admin/premium.payments.php";
	break;			
	
	case "admin.premiumToAll";
		$module = "modules/admin/premium.toall.php";
	break;	

	case "admin.premiumExtra";
		$module = "modules/admin/premium.extra.php";
	break;			
	
	case "admin.deletePlayer";
		$module = "modules/admin/deletePlayer.php";
	break;		

	case "admin.logs.loginTries";
		$module = "modules/admin/logs.loginTries.php";
	break;
	
	case "admin.logs.siteActions";
		$module = "modules/admin/logs.siteactions.php";
	break;		
	
	case "admin.logs.shopBeneficts";
		$module = "modules/admin/logs.shopBeneficts.php";
	break;			

	case "admin.logs.shopItems";
		$module = "modules/admin/logs.shopItem.php";
	break;			
	
	case "admin.checkItems";
		$module = "modules/admin/checkItems.php";
	break;	
	
	case "admin.bansView";
		$module = "modules/admin/bans.view.php";
	break;	
	
	case "admin.allToTemple";
		$module = "modules/admin/allToTemple.php";
	break;

	case "admin.newMember";
		$module = "modules/admin/newMember.php";
	break;		
	
	case "admin.whoisonline";
		$module = "modules/admin/whoisonline.php";
	break;		

	case "admin.tutorsManager";
		$module = "modules/admin/tutorsManager.php";
	break;	

	case "admin.statistics";
		$module = "modules/admin/statistics.php";
	break;			
	
	case "admin.updateAllAccounts";
		$module = "modules/admin/account.UpdateAll.php";
		$page["subTitle"] = "Atualização de Todas Contas";
		$page["access"] = GROUP_GOD;
	break;		
	
	
	default:
		$module = "modules/news/last.php";
	break;		
}

if(($page["access"] > $engine->accountAccess()) OR ($needLogin AND !$engine->loggedIn()))
{
	$module = "modules/others/notFound.php";
	$page["subTitle"] = "Pagina não Encontrada";
}
?>