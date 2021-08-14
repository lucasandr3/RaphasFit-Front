let appVersion = "1.0.0";
let appDeveloper = "MLV Tech";

let controlVersion = {appVersion, appDeveloper};
let lsVersionApp = localStorage.getItem('version-app');

if(!lsVersionApp) {
    window.localStorage.clear();
    window.localStorage.setItem('version-app', JSON.stringify(controlVersion));
    window.location.href = "https://raphasfit.com.br/"
}
