from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()
    # Use the correct port now that .env is set up
    page.goto("http://localhost:5173")
    # Wait for the product grid to be visible to ensure the page is loaded
    page.wait_for_selector('div.grid')
    page.screenshot(path="jules-scratch/verification/homepage_corrected.png")
    browser.close()

with sync_playwright() as playwright:
    run(playwright)
