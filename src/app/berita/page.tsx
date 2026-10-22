import Link from "next/link";
import { getPosts } from "@/lib/data";
import { uploadUrl, limitWords, formatDate } from "@/lib/helper";

export const metadata = {
  title: "Berita & Pengumuman",
  description:
    "Informasi terpercaya seputar kegiatan keumatan, kajian, dan pengumuman DKM Musholla Ar-rahman.",
};

export default async function BeritaPage({
  searchParams,
}: {
  searchParams: Promise<{ kategori?: string; q?: string }>;
}) {
  const resolvedSearchParams = await searchParams;
  const category = resolvedSearchParams.kategori || "";
  const query = (resolvedSearchParams.q || "").toLowerCase().trim();

  const allPosts = await getPosts();

  const posts = allPosts.filter((post) => {
    const matchesCat = category ? post.category === category : true;
    const matchesQuery = query
      ? post.title.toLowerCase().includes(query) ||
        post.content.toLowerCase().includes(query)
      : true;
    return matchesCat && matchesQuery;
  });

  return (
    <>
      {/* Header Berita & Pengumuman */}
      <section className="py-5 bg-white border-bottom">
        <div className="container text-center py-4">
          <span className="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
            WARTA & INFORMASI
          </span>
          <h1 className="fw-bold mb-2">Berita & Pengumuman Musholla Ar-rahman</h1>
          <p className="text-muted m-0">
            Informasi terpercaya seputar kegiatan keumatan, kajian, dan pengumuman DKM
          </p>
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          {/* Pencarian & Filter Kategori */}
          <div className="row g-3 align-items-center mb-4">
            <div className="col-md-6">
              <div className="d-flex flex-wrap gap-2">
                <Link
                  href="/berita"
                  className={`btn btn-sm rounded-pill px-3 fw-bold ${
                    !category ? "btn-success" : "btn-light border"
                  }`}
                >
                  Semua Kategori
                </Link>
                <Link
                  href={`/berita?kategori=Berita${query ? `&q=${encodeURIComponent(query)}` : ""}`}
                  className={`btn btn-sm rounded-pill px-3 fw-bold ${
                    category === "Berita" ? "btn-success" : "btn-light border"
                  }`}
                >
                  Berita
                </Link>
                <Link
                  href={`/berita?kategori=Pengumuman${query ? `&q=${encodeURIComponent(query)}` : ""}`}
                  className={`btn btn-sm rounded-pill px-3 fw-bold ${
                    category === "Pengumuman" ? "btn-success" : "btn-light border"
                  }`}
                >
                  Pengumuman
                </Link>
              </div>
            </div>

            <div className="col-md-6">
              <form action="/berita" method="GET" className="d-flex gap-2">
                {category && <input type="hidden" name="kategori" value={category} />}
                <input
                  type="text"
                  name="q"
                  defaultValue={query}
                  className="form-control form-control-sm rounded-pill px-3"
                  placeholder="Cari berita atau pengumuman..."
                />
                <button type="submit" className="btn btn-sm btn-success rounded-pill px-3">
                  <i className="bi bi-search"></i>
                </button>
                {query && (
                  <Link
                    href={`/berita${category ? `?kategori=${encodeURIComponent(category)}` : ""}`}
                    className="btn btn-sm btn-outline-secondary rounded-pill"
                  >
                    Reset
                  </Link>
                )}
              </form>
            </div>
          </div>

          {/* Daftar Berita */}
          {posts.length > 0 ? (
            <div className="row g-4">
              {posts.map((post) => (
                <div key={post.id} className="col-md-6 col-lg-4">
                  <div className="custom-card">
                    <img
                      src={uploadUrl(post.image)}
                      alt={post.title}
                      className="custom-card-img"
                    />
                    <div className="custom-card-body">
                      <div className="d-flex justify-content-between align-items-center mb-2">
                        <span
                          className={`card-badge ${
                            post.category === "Pengumuman"
                              ? "card-badge-pengumuman"
                              : "card-badge-berita"
                          }`}
                        >
                          {post.category}
                        </span>
                        <small className="text-muted">
                          <i className="bi bi-calendar3 me-1"></i>
                          {formatDate(post.created_at)}
                        </small>
                      </div>
                      <h5 className="fw-bold fs-6 mb-2">
                        <Link href={`/berita/${post.slug}`} className="text-decoration-none text-dark">
                          {post.title}
                        </Link>
                      </h5>
                      <p className="text-muted small mb-3 flex-grow-1">
                        {limitWords(post.content, 20)}
                      </p>
                      <div className="border-top pt-2 d-flex justify-content-between align-items-center">
                        <small className="text-muted">
                          <i className="bi bi-person me-1"></i>
                          {post.author || "DKM"}
                        </small>
                        <Link
                          href={`/berita/${post.slug}`}
                          className="text-success fw-bold small text-decoration-none"
                        >
                          Baca <i className="bi bi-arrow-right"></i>
                        </Link>
                      </div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <div className="alert alert-light border text-center p-5 rounded-4 shadow-sm">
              <i className="bi bi-search fs-1 text-muted d-block mb-2"></i>
              <h5 className="fw-bold text-muted">Tidak ada artikel yang ditemukan</h5>
              <p className="text-muted small m-0">
                Coba gunakan kata kunci lain atau pilih kategori yang berbeda.
              </p>
            </div>
          )}
        </div>
      </section>
    </>
  );
}
