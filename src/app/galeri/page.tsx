import GalleryView from "@/components/GalleryView";
import { getGalleries } from "@/lib/data";

export const metadata = {
  title: "Galeri Foto Kegiatan & Fasilitas",
  description:
    "Dokumentasi foto kegiatan ibadah, kajian, dan silaturahmi warga Musholla Ar-rahman Gembor Periuk.",
};

export default async function GaleriPage() {
  const galleries = await getGalleries();

  return (
    <>
      {/* Header Galeri */}
      <section className="py-5 bg-white border-bottom">
        <div className="container text-center py-4">
          <span className="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
            DOKUMENTASI FOTO
          </span>
          <h1 className="fw-bold mb-2">Galeri Kegiatan & Fasilitas Musholla Ar-rahman</h1>
          <p className="text-muted m-0">
            Rekam jejak kebersamaan ibadah jamaah dan pemeliharaan sarana musholla
          </p>
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          <GalleryView items={galleries} />
        </div>
      </section>
    </>
  );
}
