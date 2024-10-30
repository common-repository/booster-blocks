document.addEventListener('DOMContentLoaded', () => {
    const bb_alerts = document.querySelectorAll('.bb-alert');
    for(const bb_alert of bb_alerts){
        const dismiss_button = bb_alert.querySelector('.bb-alert-dismiss');
        if(dismiss_button){
            dismiss_button.addEventListener('click',() => {
                bb_alert.classList.add('alert-dismiss');
                setTimeout(hideAlert,800)
            });
        }
        function hideAlert(){
            bb_alert.style.display = "none";
        }
        
    } 
    
});