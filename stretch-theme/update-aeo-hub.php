<?php
/**
 * WP-CLI script: Update AEO hub content option
 * Run: wp eval-file stretch-theme/update-aeo-hub.php
 */

$hub = [
    'headline' => 'Answer Engine Optimization (AEO)',
    'subtitle' => 'The complete guide to getting your content cited by AI-powered search engines like ChatGPT, Gemini, and Perplexity.',
    'intro' => '<p>Something fundamental has shifted in how people find information. Instead of scanning ten blue links and clicking through to websites, a growing number of users are asking AI systems directly — and getting synthesized answers that cite specific brands and sources.</p><p>For content marketers, this changes everything. The brands appearing in those AI-generated answers aren\'t there by accident. They\'ve structured their content, built their authority, and optimized their digital presence for a new kind of search: <strong>Answer Engine Optimization</strong>.</p><p>This guide walks you through the complete AEO landscape — from understanding what it is and how AI systems choose sources, to the tactical playbook for implementation and the metrics that prove it\'s working. Each section links to a deeper guide if you want to go further.</p>',
    'chapters' => [
        ['title' => 'Understanding AEO', 'sections' => [0,1,2]],
        ['title' => 'The AEO Playbook', 'sections' => [3,4,5,6]],
        ['title' => 'Proving the Impact', 'sections' => [7,8,9]],
    ],
    'sections' => [
        [
            'heading' => 'What Is Answer Engine Optimization?',
            'content' => '<p>Answer Engine Optimization is the practice of structuring your content, brand signals, and digital presence so that AI-powered answer engines cite, reference, and recommend your brand when responding to user queries.</p><p>Unlike traditional SEO, which focuses on ranking in a list of blue links, AEO focuses on becoming the source that AI systems trust and surface in their generated responses. When someone asks ChatGPT or Perplexity a question in your industry, AEO determines whether your brand appears in the answer.</p><p>The distinction matters because the user behavior is fundamentally different. In traditional search, you compete for clicks. In AI-powered search, you compete for <em>citations</em>. And the signals that drive each are not the same.</p>',
            'article_slug' => 'what-is-answer-engine-optimization-beginners-guide',
            'card_style' => 'card',
        ],
        [
            'heading' => 'AEO vs Traditional SEO',
            'content' => '<p>While SEO and AEO share common foundations — authoritative content, clear structure, topical depth — they diverge in critical ways. Understanding where they overlap and where they split is essential for allocating your resources effectively.</p>',
            'table' => '<table><thead><tr><th></th><th>Traditional SEO</th><th>AEO</th></tr></thead><tbody><tr><td><strong>Goal</strong></td><td>Rank on page 1</td><td>Get cited in AI answers</td></tr><tr><td><strong>Format</strong></td><td>Keywords in content</td><td>Structured, definitive answers</td></tr><tr><td><strong>Signals</strong></td><td>Backlinks, domain authority</td><td>Expertise, clarity, structure</td></tr><tr><td><strong>User Action</strong></td><td>Click to website</td><td>Brand mention in AI response</td></tr><tr><td><strong>Measurement</strong></td><td>Rankings, organic traffic</td><td>Citations, brand visibility in AI</td></tr></tbody></table>',
            'content_after_table' => '<p>The most effective strategies now address both simultaneously. SEO drives the traffic; AEO builds the brand presence in the AI layer that sits on top of search. Neither replaces the other — but ignoring AEO means ceding an increasingly important channel to your competitors.</p>',
            'article_slug' => 'aeo-vs-seo',
            'card_style' => 'inline',
        ],
        [
            'heading' => 'How AI Answer Engines Choose Sources',
            'content' => '<p>AI answer engines use retrieval-augmented generation (RAG) to pull in real-time information when responding to queries. They don\'t just recall memorized training data — they actively search, evaluate, and synthesize information from multiple sources to construct each response.</p><p>The selection process favors content that demonstrates clear expertise, provides definitive answers, and is structured in ways that machines can easily parse. Vague, hedging, or poorly organized content gets skipped in favor of sources that state things clearly and back them up with evidence.</p>',
            'pullquote' => 'AI systems don\'t reward the most content — they reward the most <em>useful</em> content. Clarity and structure beat volume every time.',
            'content_after' => '<p>This understanding is the foundation of everything that follows. Once you know how these systems evaluate and select sources, every tactical decision — from heading structure to schema markup — becomes more intentional.</p>',
            'article_slug' => 'how-ai-answer-engines-choose-brands-to-cite',
            'card_style' => 'card',
        ],
        [
            'heading' => 'Structuring Content for AI Comprehension',
            'content' => '<p>AI models parse content hierarchically, much like a well-trained editor reading for structure before substance. Clear H2/H3 heading hierarchies, concise topic sentences, and definitive statements make your content dramatically easier for AI to understand and cite.</p><p>The inverted pyramid approach — stating your answer first, then providing supporting context — mirrors exactly how AI systems extract and present information. When your content leads with the answer, AI doesn\'t have to dig for it.</p><p>Specific formatting patterns matter: numbered lists for processes, comparison tables for evaluations, and clear definitions for concepts. Each format type signals to AI what kind of information it\'s looking at and how to use it.</p>',
            'article_slug' => 'structure-content-for-ai',
            'card_style' => 'inline',
        ],
        [
            'heading' => 'Schema Markup: The Technical Foundation',
            'content' => '<p>Schema markup provides machine-readable signals that help AI understand the context and relationships within your content. Think of it as metadata that explicitly tells AI systems: "This is an FAQ," "This is a how-to guide," "This person is the expert author."</p><p>FAQ schema, HowTo schema, Article schema, and Organization schema each play distinct roles. FAQ schema is particularly powerful for AEO because it mirrors the question-and-answer format that AI systems use natively. When your content is already structured as Q&A with proper schema, you\'re speaking the AI\'s language.</p><p>Schema alone won\'t guarantee citations, but its absence creates unnecessary friction. It\'s table stakes for any serious AEO effort.</p>',
            'article_slug' => 'schema-markup-for-aeo-technical-guide',
            'card_style' => 'card',
        ],
        [
            'heading' => 'Building Topical Authority Through Content Clusters',
            'content' => '<p>AI systems evaluate not just individual pages but your brand\'s overall depth on a topic. A single great article can earn a citation, but a comprehensive content ecosystem signals genuine authority — the kind that AI systems weight heavily in source selection.</p><p>The content cluster model — a pillar page supported by detailed spoke content — creates exactly this signal. This hub you\'re reading right now is an example: a central resource on AEO supported by deep-dive guides on each subtopic.</p>',
            'keypoints' => [
                'Create a pillar page that provides comprehensive topic coverage',
                'Build spoke articles that go deep on each subtopic',
                'Link everything together with intentional internal linking',
                'Cover the topic from multiple angles — beginner, tactical, advanced',
                'Update regularly to maintain freshness signals',
            ],
            'content_after' => '<p>This architecture does double duty: it serves traditional SEO through topical relevance and internal link equity, while simultaneously building the authority signals that AI systems use to evaluate source credibility.</p>',
            'article_slug' => 'building-topical-authority-content-cluster-strategy-aeo',
            'card_style' => 'inline',
        ],
        [
            'heading' => 'Featured Snippets: The Bridge Between SEO and AEO',
            'content' => '<p>Featured snippets in traditional search remain one of the strongest bridges to AEO success. Content that earns Position Zero demonstrates exactly the qualities that AI answer engines look for: clear structure, definitive answers, and authoritative sourcing.</p><p>The connection is more than theoretical. Many AI systems reference the same sources that earn featured snippets, and the optimization techniques are nearly identical. Winning snippets is a two-for-one strategy that serves both traditional SEO and emerging AEO goals simultaneously.</p><p>Focus on question-format headings, concise answer paragraphs (40-60 words), and structured lists or tables. These formats perform well in both featured snippets and AI citations.</p>',
            'article_slug' => 'featured-snippets-bridge-to-aeo',
            'card_style' => 'card',
        ],
        [
            'heading' => 'E-E-A-T: The Trust Signals AI Actually Evaluates',
            'content' => '<p>Experience, Expertise, Authoritativeness, and Trustworthiness are not just Google\'s quality guidelines — they\'re the fundamental attributes that AI systems evaluate when choosing which sources to cite. The signals are different from traditional SEO authority metrics like Domain Rating.</p><p>AI systems look for verifiable author credentials, consistent factual accuracy, cited sources, and first-hand experience signals. A bylined article from a recognized expert with linked credentials gets cited more than anonymous content, regardless of the publishing domain\'s SEO metrics.</p><p>Practical steps: detailed author bios with verifiable credentials, expert review processes, consistent accuracy across your content library, and transparent sourcing. These aren\'t just nice-to-haves anymore — they\'re competitive necessities.</p>',
            'article_slug' => 'eeat-signals-ai-answer-engines-evaluate',
            'card_style' => 'inline',
        ],
        [
            'heading' => 'The Competitive Advantage of Original Research',
            'content' => '<p>AI models heavily favor original data, unique research findings, and proprietary insights. This makes intuitive sense: when your content includes statistics or analysis that can\'t be found elsewhere, AI systems <em>must</em> cite you as the source. There\'s no alternative.</p>',
            'pullquote' => 'Original research is the strongest AEO signal because it creates content that AI systems can only attribute to you. No one else has your data.',
            'content_after' => '<p>Annual surveys, industry benchmarks, proprietary data analysis, and original case studies all create this kind of defensible advantage. The investment compounds: each piece of original research reinforces your authority and makes future citations more likely.</p><p>Start small if needed — even a single original data point in an otherwise standard article makes it more citation-worthy than competitors relying entirely on secondary sources.</p>',
            'article_slug' => 'original-research-data-aeo-competitive-advantage',
            'card_style' => 'card',
        ],
        [
            'heading' => 'Measuring What Matters',
            'content' => '<p>Traditional SEO metrics — rankings, organic traffic, click-through rates — remain important but they only tell half the story. AEO introduces new dimensions of measurement that capture your brand\'s visibility in the AI layer.</p><p>AI citation frequency tracks how often your brand appears in AI-generated responses. Brand radar tools monitor mentions across ChatGPT, Gemini, Perplexity, and other platforms. Share of voice in AI responses measures your visibility relative to competitors for target topics.</p><p>The most forward-thinking brands are building unified dashboards that combine traditional SEO metrics with AEO-specific measurements. This complete picture reveals opportunities that neither dataset shows alone.</p>',
            'article_slug' => 'measuring-aeo-success-metrics-tools-reporting',
            'card_style' => 'card',
        ],
    ],
];

update_option('stretch_hub_aeo', $hub);
echo "AEO hub content updated successfully.\n";
