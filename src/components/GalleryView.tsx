"use client";

import { useState } from "react";
import { GalleryItem } from "@/types";
import { uploadUrl } from "@/lib/helper";

interface GalleryViewProps {
  items: GalleryItem[];
}

export default function GalleryView({ items }: GalleryViewProps) {
  const [selectedCategory, setSelectedCategory] = useState("Semua");
  const [lightboxImg, setLightboxImg] = useState<{ src: string; title: string } | null>(null);

  const categories = [
    "Semua",
    ...Array.from(new Set(items.map((i) => i.category || "Kegiatan"))),
  ];

  const filtered =
    selectedCategory === "Semua"
      ? items
      : items.filter((i) => (i.category || "Kegiatan") === selectedCategory);

  return (
    <>
      {/* Filter Kategori Galeri */}
      <div className="d-flex flex-wrap justify-content-center gap-2 mb-4">
        {categories.map((cat) => (
          <button
            key={cat}
            onClick={() => setSelectedCategory(cat)}
            className={`btn btn-sm rounded-pill px-4 fw-bold ${
              selectedCategory === cat
                ? "btn-success text-white"
                : "btn-light border"
            }`}
          >
            {cat === "Semua" ? "Semua Foto" : cat}
          </button>
        ))}
      </div>

      {filtered.length > 0 ? (
        <div className="gallery-grid">
          {filtered.map((gal) => {
            const imgSrc = uploadUrl(gal.image);
            return (
              <div
                key={gal.id}
                className="gallery-item cursor-pointer"
                onClick={() => setLightboxImg({ src: imgSrc, title: gal.title })}
                data-title={gal.title}
              >
                <img src={imgSrc} alt={gal.title} loading="lazy" />
                <div className="gallery-overlay">
                  <span className="badge bg-warning text-dark mb-1 small">
                    {gal.category || "Kegiatan"}
                  </span>
                  <h6 className="m-0 text-white fw-bold small">{gal.title}</h6>
                  <small className="text-white-50 d-block mt-1">
                    <i className="bi bi-zoom-in me-1"></i> Klik untuk memperbesar
                  </small>
                </div>
              </div>
            );
          })}
        </div>
      ) : (
        <div className="alert alert-light border text-center p-5 rounded-4 shadow-sm">
          <i className="bi bi-images fs-1 text-muted d-block mb-2"></i>
          <h5 className="fw-bold text-muted">Belum ada foto dalam kategori ini</h5>
          <p className="text-muted small m-0">Pengurus akan segera mengunggah dokumentasi terbaru.</p>
        </div>
      )}

      {/* Lightbox Modal */}
      {lightboxImg && (
        <div
          className="modal fade show d-block"
          tabIndex={-1}
          style={{ background: "rgba(0,0,0,0.85)" }}
          onClick={() => setLightboxImg(null)}
        >
          <div
            className="modal-dialog modal-dialog-centered modal-lg"
            onClick={(e) => e.stopPropagation()}
          >
            <div className="modal-content bg-dark border-0 text-white">
              <div className="modal-header border-0 pb-0">
                <h6 className="modal-title">{lightboxImg.title}</h6>
                <button
                  type="button"
                  className="btn-close btn-close-white"
                  onClick={() => setLightboxImg(null)}
                  aria-label="Tutup"
                />
              </div>
              <div className="modal-body text-center p-3">
                <img
                  src={lightboxImg.src}
                  className="img-fluid rounded-3 shadow"
                  alt={lightboxImg.title}
                  style={{ maxHeight: "75vh" }}
                />
              </div>
            </div>
          </div>
        </div>
      )}
    </>
  );
}
