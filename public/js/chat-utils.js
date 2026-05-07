/**
 * UMKM Store - Chat Utilities
 */
document.addEventListener('DOMContentLoaded', () => {
    scrollToBottom('chatMessages');
});

/**
 * Auto scroll chat container to the bottom
 */
function scrollToBottom(containerId) {
    const chatMessages = document.getElementById(containerId);
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}
