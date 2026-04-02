<?php
/**
 * Create AEO spoke posts for the content hub.
 * Run via: wp eval-file create-aeo-spokes.php --allow-root
 */

$aeo_category_id = 9;
$author_id = 1;

$posts = [
    [
        'title'   => 'What Is Answer Engine Optimization? A Complete Beginner\'s Guide',
        'slug'    => 'what-is-answer-engine-optimization-beginners-guide',
        'image'   => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800&h=450&fit=crop',
        'content' => '<p>Search is changing — and if you\'re still optimizing exclusively for blue links, you\'re already behind. Answer Engine Optimization (AEO) is the practice of structuring your content so that AI-powered tools like ChatGPT, Perplexity, and Google\'s AI Overviews can understand, trust, and cite it when users ask questions.</p>

<h2>What Exactly Is an Answer Engine?</h2>
<p>Answer engines are AI systems that synthesize information from across the web and deliver a single, direct response — no click required. Unlike traditional search engines that return a list of links, answer engines do the reading for you. Tools like Perplexity AI, ChatGPT with browsing, and Google\'s AI Overviews all function this way. They pull from sources they deem credible, accurate, and well-structured, then cite those sources in their responses.</p>
<p>AEO is the discipline of making sure your brand is one of those cited sources. It\'s not about gaming an algorithm — it\'s about genuinely being the most useful, authoritative answer to a question your audience is asking.</p>

<blockquote><p>"The brands that win in AI-driven search are the ones that have already done the work to be genuinely useful — AEO is about making that usefulness visible to machines."</p></blockquote>

<h2>How AEO Differs from Traditional SEO</h2>
<p>SEO is largely about rankings — getting your page to appear near the top of a results page. AEO is about citations — getting your brand mentioned or linked in an AI-generated answer. The tactics overlap (quality content, strong E-E-A-T signals, technical health), but the optimization targets are different.</p>
<p>With SEO, you compete for position. With AEO, you compete for credibility. AI systems evaluate whether your content directly answers a question, whether it\'s structured clearly, and whether your site demonstrates topical authority in that subject area.</p>

<h2>Who Needs AEO Right Now?</h2>
<p>Any brand that relies on organic search should be paying attention. B2B companies with complex buying journeys are particularly exposed — their prospects are increasingly asking AI tools for vendor comparisons, how-to guidance, and category education. If your competitors are being cited and you\'re not, you\'re invisible at a critical moment in the funnel.</p>
<p>The good news: AEO is still early. The brands investing now will build citation authority before the discipline becomes saturated.</p>',
    ],
    [
        'title'   => 'How AI Answer Engines Choose Which Brands to Cite',
        'slug'    => 'how-ai-answer-engines-choose-brands-to-cite',
        'image'   => 'https://images.unsplash.com/photo-1555255707-c07966088b7b?w=800&h=450&fit=crop',
        'content' => '<p>When a user asks Perplexity or ChatGPT a question, they get a confident, synthesized answer — with citations. But how does the AI decide which sources to pull from? Understanding this process is foundational to any AEO strategy.</p>

<h2>How RAG Systems Select Sources</h2>
<p>Most modern AI answer engines use a technique called Retrieval-Augmented Generation (RAG). Rather than relying purely on what the model learned during training, RAG systems query a live index of web content, retrieve the most relevant passages, and use those passages to generate the final answer. The model doesn\'t just pick the first result — it evaluates multiple sources and selects the ones that best match the query intent, contain clear and accurate information, and come from domains with strong trust signals.</p>
<p>This means your content needs to be both retrievable and credible. It needs to show up in the index, and it needs to clearly answer the question being asked — not dance around it.</p>

<blockquote><p>"AI models don\'t read your page the way a human does. They extract structured meaning. If your content buries the answer in five paragraphs of preamble, the model may skip it entirely."</p></blockquote>

<h2>Trust Signals AI Systems Evaluate</h2>
<p>AI systems lean on many of the same trust proxies that Google uses — domain authority, backlink profiles, structured data, and author credentials. But they also weight how directly your content answers the query. Pages that open with a clear, concise definition or response are significantly more likely to be cited than pages that require the reader (or model) to hunt for the answer.</p>
<p>Other key trust signals include: consistent brand mentions across authoritative third-party sites, properly implemented schema markup, and a clean site architecture that makes topical expertise obvious.</p>

<h2>What This Means for Your Content Strategy</h2>
<p>Stop writing content designed to rank and start writing content designed to answer. Lead with the answer. Use clear headings that mirror how users actually phrase questions. Ensure your brand is mentioned positively on third-party sites that AI systems trust. And make sure your technical foundation — schema, crawlability, site speed — is solid enough that your content gets indexed and retrieved in the first place.</p>',
    ],
    [
        'title'   => 'Schema Markup for AEO: The Technical Guide',
        'slug'    => 'schema-markup-for-aeo-technical-guide',
        'image'   => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=800&h=450&fit=crop',
        'content' => '<p>Schema markup is structured data that helps both search engines and AI systems understand what your content is about — not just what it says, but what it means. For AEO, schema is one of the most high-leverage technical investments you can make. It gives AI models explicit signals about the nature of your content, the credibility of your organization, and the structure of the answers you provide.</p>

<h2>The Schema Types That Matter Most for AEO</h2>
<p><strong>FAQ Schema</strong> is arguably the most important for AEO. It marks up question-and-answer pairs directly in your HTML, making it trivial for AI systems to identify and extract precise answers. If you\'re targeting informational queries, FAQ schema should be on every relevant page.</p>
<p><strong>HowTo Schema</strong> is essential for procedural content. When a user asks an AI how to do something, a properly marked-up HowTo page gives the model a clean list of steps it can surface directly — dramatically increasing your citation chances for how-to queries.</p>
<p><strong>Article Schema</strong> signals that your content is editorial in nature and includes important metadata: author name, publication date, and organization. AI systems use this to evaluate freshness and authoritativeness. Always include <code>datePublished</code>, <code>dateModified</code>, and a linked <code>author</code> entity.</p>
<p><strong>Organization Schema</strong> on your homepage establishes your brand as a named entity. Include your logo, social profiles, founding date, and a clear description. This helps AI models recognize your brand and associate your content with a trusted organization.</p>

<blockquote><p>"Schema markup isn\'t magic — it won\'t rescue bad content. But on strong content, it\'s the difference between being understood and being overlooked."</p></blockquote>

<h2>Implementation Steps</h2>
<p>Start with a schema audit: identify your highest-traffic informational pages and check whether they have any structured data. Use Google\'s Rich Results Test and Schema.org\'s validator to verify existing markup. Then prioritize: add FAQ schema to your top question-answering pages first, HowTo schema to procedural guides, and ensure Organization and Article schema are site-wide defaults.</p>
<p>Implement schema in JSON-LD format (Google\'s preferred method) and keep it in the <code>&lt;head&gt;</code> of your document. Test after every deployment. Schema errors silently undermine your AEO efforts — regular validation is non-negotiable.</p>',
    ],
    [
        'title'   => 'Building Topical Authority: The Content Cluster Strategy for AEO',
        'slug'    => 'building-topical-authority-content-cluster-strategy-aeo',
        'image'   => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=800&h=450&fit=crop',
        'content' => '<p>AI answer engines don\'t just evaluate individual pages — they evaluate domains. A site that covers a topic comprehensively and consistently signals expertise in a way that a single well-written article never can. This is the core logic behind topical authority, and it\'s why content cluster strategy is central to AEO success.</p>

<h2>The Pillar and Spoke Model</h2>
<p>A content cluster is built around a pillar page — a comprehensive, authoritative guide on a broad topic — and a collection of spoke pages that dive deep into specific subtopics. The pillar page links to each spoke; each spoke links back to the pillar. This internal linking architecture signals to AI systems (and to Google) that your site doesn\'t just touch on a topic — it owns it.</p>
<p>For AEO, the pillar page should answer the broadest version of the question your audience is asking. Spoke pages handle the more specific queries: "how does X work," "what is the difference between X and Y," "step-by-step guide to X." Each spoke should be a self-contained, authoritative answer to a specific question — the kind of clear, direct content that AI systems love to cite.</p>

<blockquote><p>"A single great article can earn a citation. A complete content cluster earns a reputation. AI systems are starting to distinguish between the two."</p></blockquote>

<h2>Depth Over Volume</h2>
<p>The mistake most brands make is equating content quantity with topical authority. Fifty shallow posts don\'t outperform ten deep ones. AI models can assess content quality — they\'re trained on enormous amounts of text and have a strong signal for whether a piece actually explains a concept or just name-drops keywords.</p>
<p>Prioritize depth. Each spoke post should leave the reader (and the AI) with no follow-up questions on that specific subtopic. Use examples, data, clear definitions, and structured formatting. Answer the question completely.</p>

<h2>Internal Linking as an Authority Signal</h2>
<p>Internal links do more than help users navigate — they define your content architecture. When your spoke pages consistently link to your pillar, and your pillar links back to your spokes, you create a web of contextual relevance that reinforces topical expertise. Use descriptive anchor text that reflects the target page\'s topic. Avoid generic phrases like "click here." Every internal link is an opportunity to communicate meaning.</p>',
    ],
    [
        'title'   => 'Featured Snippets as the Bridge to AEO',
        'slug'    => 'featured-snippets-bridge-to-aeo',
        'image'   => 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=800&h=450&fit=crop',
        'content' => '<p>Featured snippets — those concise answer boxes that appear at the top of Google search results — have long been the holy grail of SEO content. But their significance has grown: the same content signals that earn a featured snippet are closely correlated with the signals that cause AI systems to cite your content. Understanding snippets is the fastest path to understanding AEO.</p>

<h2>What Winning Position Zero Actually Requires</h2>
<p>Google selects featured snippets from pages it already ranks on page one — so baseline SEO is a prerequisite. But among page-one results, snippet selection prioritizes pages that answer the query directly, early, and concisely. The optimal structure: state the answer in the first paragraph after the heading that mirrors the query. Keep it between 40 and 60 words. Follow it with supporting detail.</p>
<p>Snippet formats vary by query type. Paragraph snippets work for definitions and explanations. List snippets dominate how-to and step-based queries. Table snippets appear for comparison queries. Tailor your formatting to the query type you\'re targeting — and use that same formatting discipline in your AEO content strategy.</p>

<blockquote><p>"If your content can win a featured snippet, it\'s almost certainly structured well enough to be cited by an AI answer engine. The optimization targets are nearly identical."</p></blockquote>

<h2>How Snippets Feed AI Systems</h2>
<p>AI answer engines don\'t pull directly from Google\'s snippet database — but they do index the same web content that Google uses, and they apply similar selection logic. Content that earns snippets tends to be clear, direct, well-structured, and from credible domains. These are precisely the attributes AI systems evaluate when choosing what to cite.</p>
<p>There\'s also an indirect effect: pages that consistently earn snippets tend to accumulate more links and brand mentions over time, which strengthens the domain authority signals that AI systems weigh heavily.</p>

<h2>Optimization Tactics That Work for Both</h2>
<p>Use question-based headings (H2s that start with "What," "How," "Why," "When"). Follow each heading with a direct, structured answer. Use numbered lists for processes. Use definition blocks for terminology. Keep sentences tight. Eliminate filler. Every word should either inform or support — no padding.</p>',
    ],
    [
        'title'   => 'E-E-A-T Signals That AI Answer Engines Actually Evaluate',
        'slug'    => 'eeat-signals-ai-answer-engines-evaluate',
        'image'   => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&h=450&fit=crop',
        'content' => '<p>Google\'s E-E-A-T framework — Experience, Expertise, Authoritativeness, and Trustworthiness — was originally designed as a quality rater guideline for human evaluators. But the signals it captures have become central to how AI systems assess content credibility. If you want to be cited, you need to demonstrate all four dimensions — and understand how AI evaluates each one differently than a human might.</p>

<h2>Experience and Expertise: Showing Your Work</h2>
<p><strong>Experience</strong> refers to first-hand knowledge — the kind that comes from actually doing the thing you\'re writing about. AI systems look for this in the form of specificity. Vague, generic claims read as low-experience to both human readers and AI models. Precise details — actual numbers, named tools, real scenarios — read as high-experience.</p>
<p><strong>Expertise</strong> is demonstrated through depth and accuracy. Your content should reflect genuine command of the subject — not just surface familiarity. Use proper terminology. Acknowledge complexity rather than flattening it. Cite primary sources. AI systems are trained on expert-level content and can detect when a piece is written by someone who actually knows the topic versus someone who has summarized other summaries.</p>

<blockquote><p>"The easiest way to demonstrate E-E-A-T to an AI system is the same as demonstrating it to a smart human reader: be specific, be accurate, and show your reasoning."</p></blockquote>

<h2>Authoritativeness: Third-Party Validation</h2>
<p>Authority is largely an external signal — it comes from who links to you, who mentions you, and where your brand appears. AI systems weight content from domains that are cited by other authoritative sources. This means your off-page strategy matters for AEO, not just your on-page content. Earn coverage in industry publications. Build a backlink profile from credible sources. Get quoted as an expert in your category.</p>
<p>Author authority matters too. Link author bios to real credentials: publications, speaking history, LinkedIn profiles. Use Article schema to connect content to named individuals with verifiable expertise.</p>

<h2>Trust: The Foundation Everything Else Rests On</h2>
<p>Trust signals include HTTPS, accurate contact information, a clear privacy policy, consistent NAP data (name, address, phone) across the web, and an absence of factual errors. For AI systems, trust also includes content consistency — brands that publish accurate, consistent information over time build reputational signals that single-post efforts cannot replicate.</p>',
    ],
    [
        'title'   => 'Original Research & Data: The AEO Competitive Advantage',
        'slug'    => 'original-research-data-aeo-competitive-advantage',
        'image'   => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=450&fit=crop',
        'content' => '<p>In a world where AI systems can synthesize any publicly available information, generic content is a commodity. But original data — proprietary research, first-party surveys, unique benchmarks — is not. When you publish findings that exist nowhere else on the web, you become the primary source. AI systems must cite you if they want to include that information in their answers.</p>

<h2>Why Proprietary Data Creates Citation Gravity</h2>
<p>AI answer engines are trained to prefer primary sources over secondary ones. When Perplexity answers a question about industry conversion rates, it wants to cite the original survey — not a blog post that summarized the survey. If you conduct the original research, you own the citation. Every subsequent article that references your data becomes a secondary source pointing back to you, compounding your authority.</p>
<p>This creates a compounding loop: original research earns citations from AI systems, earns links from other publications, and increases domain authority — which makes your other content more likely to be cited. Original data is an investment that pays in multiple channels simultaneously.</p>

<blockquote><p>"A single well-executed original study can generate more AEO citation authority than a year\'s worth of opinion-based content. Data is the one thing AI systems can\'t hallucinate from your competitors."</p></blockquote>

<h2>How to Create Research Worth Citing</h2>
<p>You don\'t need a dedicated research team to publish original data. Start with what you already have: anonymized customer data, internal performance benchmarks, or usage patterns from your product. These can become compelling industry reports with proper framing and visualization.</p>
<p>If you don\'t have internal data, run surveys. A 200-person survey of your target audience on a focused topic can generate statistically interesting findings that no other brand in your category has published. Use tools like Pollfish, Typeform, or SurveyMonkey. Partner with a research firm if credibility is paramount.</p>

<h2>Publishing and Distributing Research for Maximum AEO Impact</h2>
<p>Structure your research content with an executive summary that leads with the most surprising or counterintuitive finding. Use clear headings, data tables, and charts. Publish a long-form report and a companion press release. Pitch the findings to relevant publications. The more secondary coverage your research generates, the more AI systems will recognize it as an authoritative primary source — and cite it accordingly.</p>',
    ],
    [
        'title'   => 'Measuring AEO Success: Metrics, Tools, and Reporting',
        'slug'    => 'measuring-aeo-success-metrics-tools-reporting',
        'image'   => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=450&fit=crop',
        'content' => '<p>AEO introduces a measurement challenge that traditional SEO doesn\'t face: AI citations often happen without a click. A user asks ChatGPT about the best project management tools, your brand gets mentioned in the answer — and no pageview is recorded. Measuring AEO success requires new metrics, new tools, and a reporting framework built for zero-click visibility.</p>

<h2>The Core AEO Metrics</h2>
<p><strong>AI Citation Rate</strong> is the foundational metric: how often is your brand mentioned in AI-generated answers when users ask questions relevant to your category? This is measured by running a panel of target queries through AI tools and tracking whether your brand appears. Tools like Profound, Brandwatch, and Ahrefs Brand Radar are building infrastructure for this kind of monitoring at scale.</p>
<p><strong>Share of Voice in AI Results</strong> compares your citation frequency to your competitors\'. If you\'re cited in 30% of relevant AI answers and your closest competitor is cited in 50%, that gap is your AEO opportunity. Track this metric over time to assess whether your content investments are moving the needle.</p>
<p><strong>Brand Sentiment in Citations</strong> is equally important — being mentioned isn\'t valuable if the context is neutral or negative. Monitor not just whether you\'re cited, but how. Is your brand positioned as a category leader, a credible resource, or just an incidental mention?</p>

<blockquote><p>"The brands winning at AEO are the ones that have built measurement infrastructure before they need it. You can\'t optimize what you\'re not tracking."</p></blockquote>

<h2>Building an AEO Reporting Dashboard</h2>
<p>A practical AEO dashboard combines several data streams: AI citation tracking (from tools like Profound or manual query testing), traditional SEO metrics from Google Search Console (featured snippet wins are a leading indicator), branded search volume trends from Google Trends, and referral traffic from AI platforms like Perplexity and ChatGPT, which do pass referral data when users click through.</p>
<p>Report these metrics weekly or bi-weekly. Layer in content publication dates so you can correlate publishing activity with citation changes. Over time, you\'ll develop a clear picture of which content types and topics drive the most AI visibility for your brand.</p>

<h2>Setting Benchmarks and Goals</h2>
<p>AEO benchmarks are nascent — most brands are starting from zero, which means the baseline is easy to beat. Set a 90-day goal to establish your current citation rate across 20–30 target queries, identify the three to five topics where competitors are consistently cited instead of you, and publish at least one piece of content specifically designed to compete in each of those gaps.</p>',
    ],
];

// Helper: download and attach image
function attach_image_to_post( $image_url, $post_id ) {
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $tmp = download_url( $image_url );
    if ( is_wp_error( $tmp ) ) {
        echo '  [WARN] Could not download image: ' . $tmp->get_error_message() . "\n";
        return false;
    }

    $file_array = [
        'name'     => 'aeo-post-' . $post_id . '.jpg',
        'tmp_name' => $tmp,
    ];

    $attachment_id = media_handle_sideload( $file_array, $post_id );

    if ( file_exists( $tmp ) ) {
        @unlink( $tmp );
    }

    if ( is_wp_error( $attachment_id ) ) {
        echo '  [WARN] Could not attach image: ' . $attachment_id->get_error_message() . "\n";
        return false;
    }

    return $attachment_id;
}

foreach ( $posts as $post_data ) {
    $slug  = $post_data['slug'];
    $title = $post_data['title'];

    // Check if post already exists
    $existing = get_page_by_path( $slug, OBJECT, 'post' );
    if ( $existing ) {
        echo "[SKIP] Post already exists: {$slug}\n";
        continue;
    }

    // Insert the post
    $post_id = wp_insert_post( [
        'post_title'    => $title,
        'post_name'     => $slug,
        'post_content'  => $post_data['content'],
        'post_status'   => 'publish',
        'post_author'   => $author_id,
        'post_category' => [ $aeo_category_id ],
        'post_type'     => 'post',
    ], true );

    if ( is_wp_error( $post_id ) ) {
        echo "[ERROR] Failed to create post '{$title}': " . $post_id->get_error_message() . "\n";
        continue;
    }

    echo "[CREATED] Post ID {$post_id}: {$title}\n";

    // Attach featured image
    echo "  Downloading featured image...\n";
    $attachment_id = attach_image_to_post( $post_data['image'], $post_id );
    if ( $attachment_id ) {
        set_post_thumbnail( $post_id, $attachment_id );
        echo "  [IMAGE] Attached image ID {$attachment_id} as featured image.\n";
    }
}

echo "\nDone. All posts processed.\n";
