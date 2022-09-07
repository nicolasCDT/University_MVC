function creationMessage()
{
	let formulaire = document.createElement("form");
	formulaire.setAttribute("action", "#");
	formulaire.setAttribute("method","post");

	let bloc_message = document.createElement("textarea");

	let bouton_envoyer = document.createElement("input");
	bouton_envoyer.setAttribute("class", "bouton_creation_message");
	bouton_envoyer.setAttribute("type", "submit");
	bouton_envoyer.setAttribute("value", "Envoyer");

	let bouton_annuler = document.createElement("input");
	bouton_annuler.setAttribute("class", "bouton_creation_message");
	bouton_annuler.setAttribute("type", "button");
	bouton_annuler.setAttribute("onclick", "supprimerBlocMessage()");
	bouton_annuler.setAttribute("value", "annuler");

	formulaire.append(bloc_message);
	formulaire.append(bouton_envoyer);
	formulaire.append(bouton_annuler);

	const insertion = document.getElementById("bloc_tri");
	const parent = insertion.parentNode;
	parent.insertBefore(formulaire, insertion);

	document.querySelector("button").style.display="none";
}

function supprimerBlocMessage()
{
	document.querySelector("#bloc_forum form").remove();
	document.querySelector("button").style.display="block";
}