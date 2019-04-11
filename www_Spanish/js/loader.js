$(document).ready(function(){
    document.body.insertAdjacentHTML('beforeend', '<div id="app-loader" class="center vertical-center loader-modal hidden" style="height: 100%; width: 100%; position: fixed; top: 0px; left: 0px; z-index: 30000;"><div style="color: rgba(0, 0, 0, 0.87); background-color: rgb(255, 255, 255); transition: none; box-sizing: border-box; font-family: sans-serif; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 6px, rgba(0, 0, 0, 0.12) 0px 1px 4px; border-radius: 50%; position: absolute; z-index: 2; width: 200px; height: 200px; padding: 20px; top: -10000px; left: -10000px; transform: translate(10000px, 10000px); opacity: 1;"><svg width="200px"  height="200px"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="lds-ball2"><g transform="translate(0,-7.5)"><circle cx="50" r="11.7448" cy="41" fill="#56b596" transform="rotate(132 50 50)"><animateTransform attributeName="transform" type="rotate" calcMode="linear" values="0 50 50;360 50 50" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite"></animateTransform><animate attributeName="r" calcMode="spline" values="0;15;0" keyTimes="0;0.5;1" dur="1" keySplines="0.2 0 0.8 1;0.2 0 0.8 1" begin="0s" repeatCount="indefinite"></animate></circle><circle cx="50" r="3.2552" cy="41" fill="#273134" transform="rotate(312 50 50)"><animateTransform attributeName="transform" type="rotate" calcMode="linear" values="180 50 50;540 50 50" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite"></animateTransform><animate attributeName="r" calcMode="spline" values="15;0;15" keyTimes="0;0.5;1" dur="1" keySplines="0.2 0 0.8 1;0.2 0 0.8 1" begin="0s" repeatCount="indefinite"></animate></circle></g></svg></div></div>');
    window.AppLoader = {
        show: function () {
            var n = document.getElementById('app-loader');
            n.className = n.className.replace('hidden', '');
        },
        hide: function () {
            var n = document.getElementById('app-loader');
            n.className = n.className.trim() + ' hidden';
        }
    };
});
