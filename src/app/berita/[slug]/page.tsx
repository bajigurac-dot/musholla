import Link from "next/link";
import { notFound } from "next/navigation";
import { getPostBySlug, getPosts } from "@/lib/data";
import { uploadUrl, formatDate, limitWords } from "@/lib/helper";

interface PostPageProps {
  params: Promise<{ slug: string }>;
}

export async function generateMetadata({ params }: PostPageProps) {
  const { slug } = await params;
  const post = await getPostBySlug(slug);
  if (!post) return { title: "Berita Tidak Ditemukan" };
  return {
    title: `${post.title} | Berita Musholla Ar-rahman`,
    description: post.excerpt || post.content.substring(0, 160),
  };
}

export default async function SinglePostPage({ params }: PostPageProps) {
  const { slug } = await params;
  const post = await getPostBySlug(slug);

  if (!post) {
    notFound();
  }

  const allPosts = await getPosts(5);
  const otherPosts = allPosts.filter((p) => p.slug !== slug).slice(0, 3);

  return (
    <>
      {/* Detail Berita / Pengumuman Header */}
      <section className="py-5 bg-white border-bottom">
        <div className="container py-3">
          <nav aria-label="breadcrumb">
            <ol className="breadcrumb small">
              <li className="breadcrumb-item">
                <Link href="/" className="text-decoration-none text-muted">
                  Beranda
                </Link>
              </li>
              <li className="breadcrumb-item">
                <Link href="/berita" className="text-decoration-none text-muted">
                  Berita
                </Link>
              </li>
              <li className="breadcrumb-item active text-success fw-bold" aria-current="page">
                {limitWords(post.title, 6)}
              </li>
            </ol>
          </nav>
          <span
            className={`badge ${
              post.category === "Pengumuman"
                ? "bg-warning-subtle text-warning-emphasis"
                : "bg-success-subtle text-success"
            } fw-bold px-3 py-2 rounded-pill mb-2`}
          >
            {post.category}
          </span>
          <h1 className="fw-bold mb-3">{post.title}</h1>
          <div className="d-flex flex-wrap align-items-center gap-3 text-muted small">
            <span>
              <i className="bi bi-person-circle text-success me-1"></i> Ditulis oleh:{" "}
              <strong>{post.author || "Pengurus DKM"}</strong>
            </span>
            <span>•</span>
            <span>
              <i className="bi bi-calendar3 me-1"></i> {formatDate(post.created_at)}
            </span>
            <span>•</span>
            <span>
              <i className="bi bi-eye me-1"></i> {post.views} kali dibaca
            </span>
          </div>
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          <div className="row g-4">
            {/* Kolom Isi Berita */}
            <div className="col-lg-8">
              <article className="bg-white border rounded-4 p-4 shadow-sm mb-4">
                {post.image && (
                  <img
                    src={uploadUrl(post.image)}
                    alt={post.title}
                    className="img-fluid rounded-3 mb-4 w-100"
                    style={{ maxHeight: 420, objectFit: "cover" }}
                  />
                )}

                <div
                  className="article-content leading-relaxed text-dark"
                  style={{ fontSize: "1.08rem", lineHeight: 1.8 }}
                  dangerouslySetInnerHTML={{ __html: post.content }}
                />

                {/* Bagikan Artikel */}
                <div className="border-top mt-5 pt-4">
                  <span className="fw-bold d-block mb-2 small text-muted">
                    Bagikan warta ini kepada sesama jamaah:
                  </span>
                  <div className="d-flex flex-wrap gap-2">
                    <a
                      href={`https://api.whatsapp.com/send?text=${encodeURIComponent(
                        post.title + " - https://musholla-arrahman.vercel.app/berita/" + post.slug
                      )}`}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="btn btn-sm btn-success"
                    >
                      <i className="bi bi-whatsapp me-1"></i> WhatsApp
                    </a>
                  </div>
                </div>
              </article>
            </div>

            {/* Sidebar Berita Terbaru */}
            <div className="col-lg-4">
              <div className="bg-white border rounded-4 p-4 shadow-sm mb-4">
                <h5 className="fw-bold mb-3 border-bottom pb-2">Warta Terbaru Lainnya</h5>
                {otherPosts.length > 0 ? (
                  <div className="d-flex flex-column gap-3">
                    {otherPosts.map((op) => (
                      <div key={op.id} className="d-flex gap-3 align-items-start border-bottom pb-3">
                        <img
                          src={uploadUrl(op.image)}
                          alt={op.title}
                          className="rounded-2 object-fit-cover"
                          style={{ width: 70, height: 70 }}
                        />
                        <div>
                          <span
                            className={`badge ${
                              op.category === "Pengumuman"
                                ? "bg-warning text-dark"
                                : "bg-success text-white"
                            } small mb-1`}
                          >
                            {op.category}
                          </span>
                          <h6 className="fw-bold fs-6 mb-1">
                            <Link
                              href={`/berita/${op.slug}`}
                              className="text-decoration-none text-dark"
                            >
                              {op.title}
                            </Link>
                          </h6>
                          <small className="text-muted d-block">
                            <i className="bi bi-calendar3 me-1"></i> {formatDate(op.created_at)}
                          </small>
                        </div>
                      </div>
                    ))}
                  </div>
                ) : (
                  <p className="text-muted small m-0">Tidak ada warta lain.</p>
                )}
              </div>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
