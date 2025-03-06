let resources = [];
let recievedPreview = [];
var userId;
const data = {};
let mainImageDimensions = {
    width: 0,
    height: 0
};

function createDraggableElements() {
    const draggableContainer = document.getElementById('draggableContainer');
    draggableContainer.innerHTML = ''; // Clear existing elements

    const displayImage = document.getElementById('displayImage');
    const imgRect = displayImage.getBoundingClientRect();

    // Update the global variable with the height and width of the main image
    mainImageDimensions.width = imgRect.width;
    mainImageDimensions.height = imgRect.height;

    Object.keys(data).forEach(key => {
        let element;
        if ((key === 'adlee_logo' || key === 'sponsor_logo' || key === 'sponsor_qr' || key === 'bbo_qr' || key === 'qr_code')) {
            // Old code for additional image drag-and-drop
            element = document.createElement('img');
            element.src = data[key].src;
            element.id = key;
            element.className = 'draggable';
            element.style.position = 'absolute';

            if(key === 'adlee_logo' || key === 'sponsor_logo') {
                element.style.width = '200px';
                element.style.height = '50px';
            } else {
                element.style.width = '100px';
                element.style.height = '100px';
            }

            element.addEventListener('dragstart', function(event) {
                event.dataTransfer.setData('text/plain', key);
                event.dataTransfer.setDragImage(element, element.width / 2, element.height / 2);
            });
        } else {
            // Create the text elements with default font size
            element = document.createElement('div');
            element.id = key;
            element.className = 'draggable';
            element.innerHTML = `<p class='text_content'>${key.replace('_', ' ')}</p>`
            element.style.fontSize = data[key].font || '20px';
            element.style.fontWeight = data[key].bold ? 'bold' : 'normal';
            element.style.fontStyle = data[key].italic ? 'italic' : 'normal';
            element.style.textDecoration = data[key].underline ? 'underline' : 'none';
            element.style.color = '#000000';
            element.style.fontFamily = 'Arial'

            const controlContainer = document.createElement('div');
            controlContainer.className = 'control-container';

            // Font size dropdown
            const dropdown = document.createElement('select');
            dropdown.className = 'dropdown';
            for (let i = 9; i <= 30; i++) {
                const option = document.createElement('option');
                option.value = `${i}px`;
                option.textContent = `${i}px`;
                if (i + "px" === data[key].font) {
                    option.selected = true;
                }
                dropdown.appendChild(option);
            }

            dropdown.addEventListener('change', function() {
                element.style.fontSize = this.value;
                data[key].font = this.value;
            });

            // Bold button
            const boldButton = document.createElement('button');
            boldButton.className = 'control-button';
            boldButton.textContent = 'B';
            boldButton.style.fontWeight = 'bold';

            boldButton.addEventListener('click', function() {
                data[key].bold = !data[key].bold;
                element.style.fontWeight = data[key].bold ? 'bold' : 'normal';
            });

            // Italic button
            const italicButton = document.createElement('button');
            italicButton.className = 'control-button';
            italicButton.textContent = 'I';
            italicButton.style.fontStyle = 'italic';

            italicButton.addEventListener('click', function() {
                data[key].italic = !data[key].italic;
                element.style.fontStyle = data[key].italic ? 'italic' : 'normal';
            });

            // Underline button
            const underlineButton = document.createElement('button');
            underlineButton.className = 'control-button';
            underlineButton.textContent = 'U';
            underlineButton.style.textDecoration = 'underline';

            underlineButton.addEventListener('click', function() {
                data[key].underline = !data[key].underline;
                element.children[0].style.textDecoration = data[key].underline ? 'underline' : 'none';
            });

            // color picker
            const colorPicker = document.createElement('input');
            colorPicker.type = 'color';
            colorPicker.id = 'favcolor';
            colorPicker.name = 'favcolor';
            colorPicker.value = '#000000';
            colorPicker.className = 'control-button';
            
            colorPicker.addEventListener('change', (e) => {
                data[key].color = e.target.value;
                element.children[0].style.color = e.target.value
                data[key].underline && (element.children[0].style.textDecorationColor = e.target.value)
            })

            // font- family 
            const fontFamilyDropdown = document.createElement('select');
            fontFamilyDropdown.className = 'dropdown';
            fontFamilyDropdown.style.width = '55px';
            const fontFamilies = [
                'Arial', 'Verdana', 'Times New Roman', 
                'Georgia', 'Courier New', 'Tahoma', 'FrankRuhlLibre', 'ganclm bold',
                'horevclm', 'journalclm', 'keteryg', 'makabiyg', 'migdalfontwin',
                'miriwin', 'MiriamLibre'
            ];
            fontFamilies.forEach(font => {
                const option = document.createElement('option');
                option.value = font;
                option.textContent = font;
                if (font === (data[key].fontFamily || 'Arial')) {
                    option.selected = true;
                }
                fontFamilyDropdown.appendChild(option);
            });
            fontFamilyDropdown.addEventListener('change', function() {
                const selectedFont = this.value;
                element.style.fontFamily = selectedFont;
                data[key].fontFamily = selectedFont;
            });



            // Append controls
            controlContainer.appendChild(dropdown);
            controlContainer.appendChild(fontFamilyDropdown);
            controlContainer.appendChild(boldButton);
            controlContainer.appendChild(italicButton);
            controlContainer.appendChild(underlineButton);
            controlContainer.appendChild(colorPicker);
            element.appendChild(controlContainer);

            // Custom drag logic for text elements
            let isDragging = false;
            let offsetX, offsetY;

            element.addEventListener('mousedown', function(event) {
                isDragging = true;
                offsetX = event.clientX - element.getBoundingClientRect().left;
                offsetY = event.clientY - element.getBoundingClientRect().top;
                document.body.style.cursor = 'move';
            });

            document.addEventListener('mousemove', function(event) {
                if (isDragging) {
                    // Get the scroll position of the window
                    let scrollLeft = window.scrollX || document.documentElement.scrollLeft;
                    let scrollTop = window.scrollY || document.documentElement.scrollTop;
            
                    // Adjust the x and y coordinates to account for the scrolling
                    let x = event.clientX - offsetX + scrollLeft;
                    let y = event.clientY - offsetY + scrollTop;
            
                    // Update the draggable element's position
                    element.style.left = `${x}px`;
                    element.style.top = `${y}px`;
                }
            });

            document.addEventListener('mouseup', function() {
                if (isDragging) {
                    isDragging = false;
                    document.body.style.cursor = 'default';

                    let scrollLeft = window.scrollX || document.documentElement.scrollLeft;
                    let scrollTop = window.scrollY || document.documentElement.scrollTop;

                    const x = element.getBoundingClientRect().left - imgRect.left + scrollLeft;
                    const y = element.getBoundingClientRect().top - imgRect.top + scrollTop;

                    data[key].x = x; 
                    data[key].y = y;
                }
            });
        }

        setTimeout(() => {
            if (key === 'sponsor_logo') {
                element.style.top = `${130 + Object.keys(data).indexOf(key) * 40}px`;
            } else if (key === 'sponsor_qr' || key === 'qr_code') {
                element.style.top = `${160 + Object.keys(data).indexOf(key) * 40}px`;
            } else if (key === 'bbo_qr') {
                element.style.top = `${220 + Object.keys(data).indexOf(key) * 40}px`;
            }else {
                element.style.top = `${100 + Object.keys(data).indexOf(key) * 40}px`;
            }
        });
        draggableContainer.appendChild(element);
    });
}

const navigateToFormStep = (stepNumber) => {
    document.querySelectorAll(".form-step").forEach((formStepElement) => {
        formStepElement.classList.add("d-none");
    });
 
    document.querySelectorAll(".form-stepper-list").forEach((formStepHeader) => {
        formStepHeader.classList.add("form-stepper-unfinished");
        formStepHeader.classList.remove("form-stepper-active", "form-stepper-completed");
    });

    document.querySelector("#step-" + stepNumber).classList.remove("d-none");
    const formStepCircle = document.querySelector('li[step="' + stepNumber + '"]');
    formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-completed");
    formStepCircle.classList.add("form-stepper-active");
    for (let index = 0; index < stepNumber; index++) {
        const formStepCircle = document.querySelector('li[step="' + index + '"]');
        if (formStepCircle) {
            formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-active");
            formStepCircle.classList.add("form-stepper-completed");
        }
    }
};

document.querySelectorAll(".btn-navigate-form-step").forEach((formNavigationBtn) => {
    formNavigationBtn.addEventListener("click", () => {
        const stepNumber = parseInt(formNavigationBtn.getAttribute("step_number"));
        if (formNavigationBtn.innerText === "Next")  {
            if (validateForm(stepNumber - 1)) {
                navigateToFormStep(stepNumber);
            }
        } else {
            navigateToFormStep(stepNumber);
        }
    });
});

function submitAllData(user_id) {
    userId = parseInt(user_id)
    const templateFileInput = document.querySelector("#step-3 input[type='file']");
    const templateFile = templateFileInput.files.length > 0 ? templateFileInput.files : "No file selected";
    if (templateFile == "No file selected") {
        alert(`Please select template first`);
        return
    } else {
        resources = [];
        const languageSelect = document.querySelector("#step-1 select");
        const languageValue = languageSelect.options[languageSelect.selectedIndex].value;
        resources.push({ step: 1, value: languageValue });
        
        // Get template category from step 2
        const categorySelect = document.querySelector("#step-2 select");
        const categoryValue = categorySelect.options[categorySelect.selectedIndex].value;
        resources.push({ step: 2, value: categoryValue });
        
        // Get file from step 3 (template selection)
        const templateFileInput = document.querySelector("#step-3 input[type='file']");
        const templateFile = templateFileInput.files.length > 0 ? templateFileInput.files : "No file selected";
        resources.push({ step: 3, value: templateFile });

        if (categoryValue === "coupon") {
            data["book_number"] = { dummyText: "123", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["coupon_number"] = { dummyText: "001", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["book_number_1"] = { dummyText: "123", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["coupon_number_1"] = { dummyText: "001", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["sponsor_name"] = { dummyText: "Coca Cola", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["sponsor_address"] = { dummyText: "USA", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["sponsor_city"] = { dummyText: "New York", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["sponsor_zipcode"] = { dummyText: "54000", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["amount_in_words"] = { dummyText: "One hundred", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["amount_in_digit"] = { dummyText: "$100", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["shorten_url"] = { dummyText: "adlee.io/short/AVMle", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["adlee_logo"] = { x: 0, y: 0, src: "../logo.png", visible: true };
            data["sponsor_logo"] = { x: 0, y: 0, src: "../images/sponsor_logo.png", visible: true };
            data["sponsor_qr"] = { x: 0, y: 0, src: "../images/sponsor_qr.png", visible: true };
            data["bbo_qr"] = { x: 0, y: 0, src: "../images/bbo_qr.png", visible: true };
        } else {
            data["sponsor_name"] = { dummyText: "Adlee", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["person_name"] = { dummyText: "Danny", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["person_title"] = { dummyText: "Mr.", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["commemoration"] = { dummyText: "In Memory Of", x: 0, y: 0, font: "20px", visible: true, bold: false, italic: false, underline: false, color: '#000000', fontFamily: "Arial" };
            data["adlee_logo"] = { x: 0, y: 0, src: "../logo.png", visible: true };
            data["sponsor_logo"] = { x: 0, y: 0, src: "../images/sponsor_logo.png", visible: true };
            data["qr_code"] = { x: 0, y: 0, src: "../images/adlee_qr.png", visible: true };
        }

        // Log the collected values
        document.getElementById('main-editor').style.display = 'block';
        document.getElementById('main-editor-btn').style.display = 'block';
        document.getElementById('info-wizard').style.display = 'none';
        startImageEditing();
        attachDragAndDropEventListners();
    }
}

function startImageEditing() {
    const displayImage = document.getElementById('displayImage');
    const editableImage = resources[2].value;
    if (editableImage) {
        const reader = new FileReader();
        reader.onload = function(e) {
            displayImage.src = e.target.result;
            displayImage.style.display = 'block';
            setTimeout(()=> {
                createDraggableElements();
            },200)
        };
        reader.readAsDataURL(editableImage[0]);
    }    
}

function attachDragAndDropEventListners() {
    const displayImage = document.getElementById('displayImage');
    displayImage.addEventListener('dragover', function(event) {
        event.preventDefault();
    });

    displayImage.addEventListener('drop', function(event) {
        event.preventDefault();
        const rect = displayImage.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;

        const elementId = event.dataTransfer.getData('text/plain');
        const draggableElement = document.getElementById(elementId);

        if (draggableElement) {
            // Get the dimensions of the element
            const elementWidth = draggableElement.offsetWidth;
            const elementHeight = draggableElement.offsetHeight;

            // Calculate the top-left position (using your existing code)
            const topLeftX = x - elementWidth / 2;
            const topLeftY = y - elementHeight / 2;

            // Calculate the top-right position
            const topRightX = topLeftX + elementWidth;
            const topRightY = topLeftY;

            // Calculate the bottom-left position
            const bottomLeftX = topLeftX;
            const bottomLeftY = topLeftY + elementHeight;

            // Calculate the bottom-right position
            const bottomRightX = topLeftX + elementWidth;
            const bottomRightY = topLeftY + elementHeight;

            const markerContainer = document.getElementById('markerContainer');
            createResizIcons(markerContainer, draggableElement, topLeftX, topLeftY, topRightX, topRightY, bottomLeftX, bottomLeftY, bottomRightX, bottomRightY, elementId )
            addResizerListener(elementId);
           
            data[elementId].x = x;
            data[elementId].y = y;
        }
    });
}

async function sendPreviewCall() {

    Object.keys(data).forEach(key => {
        if (data[key].src) {
            const imgElement = document.getElementById(key);
            if (imgElement) {
                const imgRect = imgElement.getBoundingClientRect();
                data[key].width = imgRect.width;
                data[key].height = imgRect.height;
            }
        }
    });

    const formData = new FormData();
    formData.append('file', resources[2].value[0]);
    formData.append('data', JSON.stringify(data));
    formData.append('width', mainImageDimensions.width);
    formData.append('height', mainImageDimensions.height);
    formData.append('user_id', userId);

    try {
        const response = await fetch('https://www.adlee.io/api/edit_image_preview', {
            method: 'POST',
            body: formData,
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const blob = await response.blob();
        const imageUrl = URL.createObjectURL(blob);
        recievedPreview = blob;

        const modal = document.getElementById("myModal");
        const img = document.getElementById("base64Img");
        modal.style.display = "block";
        img.src = imageUrl;

        const tempImg = new Image();
        tempImg.src = imageUrl;

        tempImg.onload = () => {
            const imageWidth = tempImg.width;
            const imageHeight = tempImg.height;
            let element =  document.getElementById('myModalContent');
            element.style.width = `${imageWidth}px`;
            console.log("Image Width:", imageWidth);
            console.log("Image Height:", imageHeight);
        };
    } catch (error) {
        console.log("ERROR ===>", error);
        console.error('Error:', error);
    }
}

function sendSaveCall() {
    const formSaveData = new FormData();
    formSaveData.append('file', resources[2].value[0]); 
    formSaveData.append('data', JSON.stringify(data));
    formSaveData.append('width', mainImageDimensions.width);
    formSaveData.append('height', mainImageDimensions.height);
    formSaveData.append('language', resources[0].value);
    formSaveData.append('type', resources[1].value);
    formSaveData.append('preview', recievedPreview);
    formSaveData.append('user_id', userId);
    const button = document.getElementById('saveBtn');
    const spiner = document.getElementById('spiner_icon');
    button.disabled = true;
    spiner.style.display = 'inline-block'
    fetch('https://www.adlee.io/api/save_file_data', {
        method: 'POST', 
        body: formSaveData,
    })
    .then(data => {
        console.log('Success:', data);
        button.disabled = true;
        spiner.style.display = 'none'
        closeModal();
        showToaster('File saved.')
        window.location.href = '/designer/dashboard';
    })


}

function showToaster(message) {
    const toaster = document.getElementById('toaster');
    toaster.innerHTML = message;
    toaster.className = "toaster show";

    setTimeout(function() {
        toaster.className = toaster.className.replace("show", "");
    }, 3000); // Hide after 3 seconds
}

function validateForm(stepNumber) {
    let form = document.forms["userAccountSetupForm"];
    let field = form.querySelector(`[name='${stepNumber}']`);

    if (!field) {
        alert(`Step ${stepNumber} field not found`);
        return false;
    }

    let value = field.value;

    if (value === "" || value === null || value === "Select Language" || value === "Select Templete Category") {
        alert(`Step ${stepNumber} must be filled out`);
        return false;
    } 

    return true;
}

function closeModal() {
    const modal = document.getElementById("myModal");
    if(modal) modal.style.display = "none";
}

function createResizIcons(parent,image, left, top, topRightX, topRightY, bottomLeftX, bottomLeftY, bottomRightX, bottomRightY, elementId ) {
    const main = document.getElementById(`main_image_render_${elementId}`);
    if (main) {
        const resizer = document.getElementById(`resize_bottom_right_${elementId}`);
        if (main) {
            main.remove();
        } 
        if (resizer) {
            resizer.remove();
        }
    } 

    const mainDiv = document.createElement('div');
    const resize_bottom_right = document.createElement('div');
    mainDiv.className = 'resizable';
    resize_bottom_right.classList = 'resizer bottom-right'
    image.style.top = top+'px';
    image.style.left = left+'px';
    resize_bottom_right.style.top  = bottomRightY - 5 +'px';
    resize_bottom_right.style.left = bottomRightX - 5 +'px';
    resize_bottom_right.setAttribute('id', `resize_bottom_right_${elementId}`)
    mainDiv.setAttribute('id', `main_image_render_${elementId}`)
    mainDiv.appendChild(image);
    mainDiv.appendChild(resize_bottom_right);
    parent.appendChild(mainDiv)
    return parent
}

function addResizerListener(id) {
    const resizable = document.getElementById(id);
    const img = document.getElementById('adlee_logo');
    const resizers = document.getElementById(`resize_bottom_right_${id}`);

    let original_width = parseFloat(getComputedStyle(resizable, null).getPropertyValue('width').replace('px', ''));
    let original_height = parseFloat(getComputedStyle(resizable, null).getPropertyValue('height').replace('px', ''));
    let original_x = resizable.getBoundingClientRect().left;
    let original_y = resizable.getBoundingClientRect().top;
    let original_mouse_x = 0;
    let original_mouse_y = 0;

    resizers.addEventListener('mousedown', function(e) {
        e.preventDefault();
        original_width = parseFloat(getComputedStyle(resizable, null).getPropertyValue('width').replace('px', ''));
        original_height = parseFloat(getComputedStyle(resizable, null).getPropertyValue('height').replace('px', ''));
        original_x = resizable.getBoundingClientRect().left;
        original_y = resizable.getBoundingClientRect().top;
        original_mouse_x = e.pageX;
        original_mouse_y = e.pageY;

        window.addEventListener('mousemove', resize);
        window.addEventListener('mouseup', stopResize);
    });

    function resize(e) {
        if (resizers.classList.contains('bottom-right')) {
            const width = original_width + (e.pageX - original_mouse_x);
            const height = original_height + (e.pageY - original_mouse_y);
            resizable.style.width = `${width}px`;
            resizable.style.height = `${height}px`;
            redrawResizer(resizable, e, id)
        }
    }

    function stopResize() {
        window.removeEventListener('mousemove', resize);
        window.removeEventListener('mouseup', stopResize);
    }
}

function redrawResizer(draggableElement, event, id) {
    const displayImage = document.getElementById('displayImage');
    const resize_bottom_right = document.getElementById(`resize_bottom_right_${id}`);
    const rect = displayImage.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;
    const elementWidth = draggableElement.offsetWidth;
    const elementHeight = draggableElement.offsetHeight;
    const width = draggableElement.clientWidth/2;
    const height = draggableElement.clientHeight/2;
    // Calculate the top-left position (using your existing code)
    const topLeftX = x - elementWidth / 2;
    const topLeftY = y - elementHeight / 2;
    if (height >= 5 && width >= 5) {
        resize_bottom_right.style.top  = height + topLeftY - 5 + 'px'; //bottomRightY - 5 +'px';
        resize_bottom_right.style.left = width + topLeftX - 5 + 'px'; //bottomRightX - 5 +'px';
    }
    data[id].x = topLeftX;
    data[id].y = topLeftY;
}