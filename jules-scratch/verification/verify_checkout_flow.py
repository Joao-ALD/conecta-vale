from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()

    # Go to login page
    page.goto("http://localhost:8000/login")

    # Login
    page.fill('input[name="email"]', "vendedor@teste.com")
    page.fill('input[name="password"]', "password")
    page.click('button[type="submit"]')

    # Add product to cart
    page.goto("http://localhost:8000/carrinho/adicionar/1")

    # Go to cart page
    page.goto("http://localhost:8000/carrinho")

    # Click checkout button
    page.click('a[href*="checkout"]')

    # Take screenshot
    page.screenshot(path="jules-scratch/verification/verification.png")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
