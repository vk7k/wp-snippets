## CF7 Redirect after send (javascript)

Debes obtener el post ID del formulario, que es diferente del ID del formulario creado por CF7

Por ejemplo, si entras al admin y pinchas para editar un formulario, en la barra de navegación verás algo como esto:
```
tusitio.com/admin.php?page=wpcf7&post=1544&action=edit
```
donde 1544 es el post ID del formualrio

### Snippet Javascript
Tienes que configurar redirectRouter, y lo demás puedes dejarlo como está.

```javascript
document.addEventListener('wpcf7mailsent', function(event) {
    
    // VARIABLES TO SETUP:
    // 1. redirect Routes List: 'Form_ID': 'Product_Slug_or_Path'
    const redirectRoutes = {
        '2665': '3330', //form ID to ID
        '2339': 'thank-you'  // Form ID to slug
    };

    // 2. Success message
    const successMessageInnerText = '📧✔'

    // 3. Delay in seconds after sent, before navigate to the next page.
    const delayInSecondsAfterSent = 2;

    const submittedForm = String(event.detail.contactFormId);
    if (redirectRoutes.hasOwnProperty(submittedForm)) {
        
        const associatedRoute = redirectRoutes[submittedForm];
        
        const successMessage = document.querySelector('.wpcf7-response-output');
        if (successMessage) {
            successMessage.style.color = '#2a5b74';
            successMessage.innerText = successMessageInnerText;
        }
        
      // Añadir un retraso de 2 segundos (2000 milisegundos) antes de redirigir
        setTimeout(function() {
            window.location.href = `https://otec.catmin.cl/?p=${associatedRoute}`;
        }, delayInSecondsAfterSent*1000);

    }
    
}, false);
