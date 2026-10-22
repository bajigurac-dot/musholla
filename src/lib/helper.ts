export function uploadUrl(path: string | null | undefined): string {
  if (!path) return "/assets/images/hero-bg-collage.jpg";
  if (path.startsWith("http://") || path.startsWith("https://")) return path;
  if (path.startsWith("/uploads/")) return path;
  if (path.startsWith("uploads/")) return `/${path}`;
  if (path.startsWith("/assets/")) return path;
  if (path.startsWith("assets/")) return `/${path}`;
  return `/uploads/${path.replace(/^\//, "")}`;
}

export function assetUrl(path: string): string {
  if (path.startsWith("/assets/")) return path;
  return `/assets/${path.replace(/^\//, "")}`;
}

export function limitWords(text: string, count: number = 20): string {
  if (!text) return "";
  const words = text.trim().split(/\s+/);
  if (words.length <= count) return text;
  return words.slice(0, count).join(" ") + "...";
}

export function formatDate(dateStr: string): string {
  if (!dateStr) return "";
  try {
    const d = new Date(dateStr);
    return d.toLocaleDateString("id-ID", {
      day: "numeric",
      month: "short",
      year: "numeric",
    });
  } catch {
    return dateStr;
  }
}
