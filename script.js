// script.js
function addClient() {
    const clientName = document.getElementById("clientName").value;
    const amountPayable = parseFloat(document.getElementById("amountPayable").value);
    const paymentStatus = document.getElementById("paymentStatus").value;
    const totalAmountPaid = parseFloat(document.getElementById("totalAmountPaid").value);
    const monthlyCharges = parseFloat(document.getElementById("monthlyCharges").value);

    const clientItem = document.createElement("li");
    clientItem.textContent = `${clientName} - Payable: $${amountPayable} - Status: ${paymentStatus}`;
    document.getElementById("clientList").appendChild(clientItem);

    // TODO: Send data to the server using AJAX for database insertion
}
