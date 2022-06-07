function alertUser(alertType, alertTitle, alertMessage ) {
    if (alertType == "success") {
        $("#modalSuccessTit").text(alertTitle);
        $("#modalSuccessDesc").text(alertMessage);
        $("#modalSuccess").fadeIn();
    } else {
        $("#modalErrorTit").text(alertTitle);
        $("#modalErrorDesc").text(alertMessage);
        $("#modalError").fadeIn();
    }
}