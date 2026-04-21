#!/bin/bash
# Upload extracted lookbook portfolio images to WP media library
# with proper titles and captions.
set -e

IMG_DIR="/tmp/lookbook-images"

upload() {
  local file="$1"
  local title="$2"
  local alt="$3"
  local caption="$4"
  docker compose exec -T wordpress wp --allow-root media import "${IMG_DIR}/${file}" \
    --title="${title}" \
    --alt="${alt}" \
    --caption="${caption}" \
    --porcelain 2>&1
}

# Content Writing Portfolio
upload "img-011-008.png" "Paperless Post — Home Sweet Home Invitation" \
  "Paperless Post home sweet home invitation design" \
  "Client: Paperless Post | Category: Blog Article"

upload "img-012-010.png" "Etsy — Wedding Invitations Listing Page" \
  "Etsy wedding invitations product listing page" \
  "Client: Etsy | Category: Product Listing Pages"

upload "img-012-011.png" "Walgreens — Chemical Peel Expert Article" \
  "Walgreens Thread article about chemical peels for acne scars" \
  "Client: Walgreens | Category: Expert-Written Content"

upload "img-013-014.jpg" "Grove Co — Meyer's Clean Day Products" \
  "Grove Collaborative Meyer's Clean Day product flatlay" \
  "Client: Grove Co | Category: User-Generated Content"

upload "img-014-018.jpg" "Grove Collaborative — Mosquito Repellents Article" \
  "Grove Collaborative article on natural mosquito repellents" \
  "Client: Grove Collaborative | Category: User-Generated Content"

upload "img-014-019.png" "Brixton x Coors — Cheers to the Originals Email" \
  "Brixton Coors Banquet email campaign" \
  "Client: Brixton | Category: Email Marketing"

upload "img-014-017.jpg" "Reef — Aerial Surfers Social Post" \
  "Reef Instagram post with aerial surfers in turquoise water" \
  "Client: Reef | Category: Social Media"

upload "img-015-023.jpg" "Reef — Surf Barrel Social Content" \
  "Reef social content with surfer inside a wave barrel" \
  "Client: Reef | Category: Social Media"

# Design & Photography Portfolio
upload "img-019-026.jpg" "Meyer's Clean Day — Dish Soap Product Photography" \
  "Meyer's Clean Day dish soap with peonies on a pink tray" \
  "Client: Meyer's Clean Day | Category: Product Photography"

upload "img-020-027.jpg" "Meyer's Clean Day — Lilac Lifestyle Photography" \
  "Meyer's Clean Day lilac-scented products with fresh lilacs" \
  "Client: Meyer's Clean Day | Category: Lifestyle Photography"

upload "img-021-028.jpg" "QuickBooks — Inflation in Canada Infographic" \
  "QuickBooks infographic on inflation impacts in Canada" \
  "Client: Intuit QuickBooks | Category: Infographics"

upload "img-013-015.jpg" "Remitly — Immigrants Pay Taxes Too Infographic" \
  "Remitly infographic on immigrants and tax contributions" \
  "Client: Remitly | Category: Infographics"

upload "img-021-030.png" "WeWork — Los Angeles Mural Photography" \
  "WeWork Los Angeles office featuring a colorful mural" \
  "Client: WeWork | Category: Lifestyle Photography"

# Video Portfolio stills
upload "img-023-031.jpg" "Vicis — Protect the Ice Brand Story" \
  "Still from Vicis Protect the Ice hockey brand film" \
  "Client: Vicis | Category: Brand Stories | Vimeo: 900872814"

upload "img-024-032.jpg" "Corporate Video — Open Road" \
  "Still from corporate video featuring an RV on an open road" \
  "Category: Corporate Video | Vimeo: 875315890"

upload "img-024-033.jpg" "Documentary — Family Flower Arranging" \
  "Still from documentary featuring family arranging flowers" \
  "Category: Documentaries | Vimeo: 875333898"

upload "img-025-034.jpg" "NHL — TV Advertisement" \
  "Still from TV commercial featuring an NHL player" \
  "Category: TV Advertisements | Vimeo: 875337016"

upload "img-025-035.jpg" "Monster Energy — X Games Aspen Social Ad" \
  "Still from Monster Energy X Games Aspen social video ad" \
  "Client: Monster Energy | Category: Social Media Ads | Vimeo: 875314882"

echo "All uploads complete."
