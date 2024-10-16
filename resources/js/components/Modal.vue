<template>
  <div class="custom-modal-backdrop" @click.self="$emit('close')">
    <div class="custom-modal">
      <div class="custom-modal-header">
        <slot name="header"></slot>
        <button class="custom-close-btn" @click="$emit('close')">×</button>
      </div>
      <div class="custom-modal-body">
        <slot name="body"></slot>
      </div>
      <div class="custom-modal-footer">
        <slot name="footer"></slot>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Backdrop to darken the background, but keep modal visible */
.custom-modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5); /* Slightly darken the background */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2000; /* Higher z-index for modal visibility */
}

/* Modal window styling */
.custom-modal {
  background: #fff;
  padding: 1.5rem;
  border-radius: 8px;
  width: 100%;
  max-width: 500px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  z-index: 2010; /* Higher than the backdrop */
  position: relative;
}

/* Header styling */
.custom-modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid #e5e5e5;
}

/* Body styling */
.custom-modal-body {
  padding: 1rem 0;
}

/* Footer styling */
.custom-modal-footer {
  display: flex;
  justify-content: flex-end;
  padding-top: 0.5rem;
  border-top: 1px solid #e5e5e5;
}

/* Close button */
.custom-close-btn {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  line-height: 1;
  color: #000;
  padding: 0;
}
</style>
