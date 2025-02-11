import grapesjs from 'grapesjs';

document.addEventListener('DOMContentLoaded', () => {
    const pageSlug = window.location.pathname.split('/').pop(); // Extract the slug from the URL

    const editor = grapesjs.init({
        container: '#gjs',
        height: '100%',
        width: 'auto',
        fromElement: true,
        storageManager: false,
        panels: { defaults: [] },
        blockManager: {
            appendTo: '#blocks',
            blocks: [
                {
                    id: 'nav-block',
                    label: 'Navigation',
                    content: `
                        <nav class="navbar">
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">About</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </nav>
                    `,
                },
            ],
        },
    });

    // Save button
    const saveButton = document.createElement('button');
    saveButton.innerText = 'Save';
    saveButton.className = 'btn btn-primary';
    saveButton.style.marginTop = '10px';
    saveButton.onclick = () => {
        const htmlContent = editor.getHtml(); // Get the HTML content
        const cssContent = editor.getCss(); // Get the CSS content

        // Send the content to the backend
        fetch(`/website/${pageSlug}/save`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ html: htmlContent, css: cssContent }),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Page saved:', data);
            alert('Page saved successfully!');
        })
        .catch(error => console.error('Error saving page:', error));
    };

    document.body.appendChild(saveButton); // Add the button to the page
});
