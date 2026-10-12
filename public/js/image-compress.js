/**
 * Compresse les images côté client avant upload (max 1280px, JPEG ~0.7).
 */
(function () {
  async function compressFile(file, maxSide = 1280, quality = 0.7) {
    if (!file || !file.type.startsWith('image/')) return file;

    const bitmap = await createImageBitmap(file);
    let { width, height } = bitmap;
    const scale = Math.min(1, maxSide / Math.max(width, height));
    width = Math.round(width * scale);
    height = Math.round(height * scale);

    const canvas = document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(bitmap, 0, 0, width, height);
    bitmap.close();

    const blob = await new Promise((resolve) =>
      canvas.toBlob(resolve, 'image/jpeg', quality)
    );
    if (!blob) return file;

    const base = file.name.replace(/\.[^.]+$/, '') || 'photo';
    return new File([blob], base + '.jpg', { type: 'image/jpeg' });
  }

  async function handleInput(input) {
    const files = Array.from(input.files || []);
    if (!files.length) return;

    const dt = new DataTransfer();
    for (const file of files) {
      dt.items.add(await compressFile(file));
    }
    input.files = dt.files;
  }

  document.addEventListener('change', function (e) {
    const input = e.target;
    if (!(input instanceof HTMLInputElement)) return;
    if (input.type !== 'file' || !input.accept.includes('image')) return;
    if (input.dataset.compress === 'false') return;
    handleInput(input).catch(console.error);
  });

  window.DaninoCompress = { compressFile };
})();
